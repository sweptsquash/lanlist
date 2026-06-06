#!/bin/bash

set -euo pipefail
trap 'echo "Script interrupted. Exiting."; exit 1' INT TERM

# Variables
HOSTS_FILE="/etc/hosts"
CERT_PATH="$(pwd)/caddy/data/caddy/pki/authorities/local/root.crt"
DOMAINS=("lanlist.dev" "app.lanlist.dev" "landlord-a.lanlist.dev" "landlord-b.lanlist.dev" "api.lanlist.dev" "ws.lanlist.dev" )

# Add domains to /etc/hosts if not present
for DOMAIN in "${DOMAINS[@]}"; do
    if ! grep -q "$DOMAIN" "$HOSTS_FILE"; then
        echo "Adding $DOMAIN to $HOSTS_FILE..."
        if [[ "$(uname)" == "Linux" ]] && grep -qi microsoft /proc/version; then
            echo "127.0.0.1  $DOMAIN" | sudo tee -a "$HOSTS_FILE" > /dev/null
            sudo sed -i "/::1[[:space:]]\+ip6-localhost[[:space:]]\+ip6-loopback/ { /$DOMAIN/! s/\$/ $DOMAIN/ }" "$HOSTS_FILE"
        else
            echo "127.0.0.1  $DOMAIN" | sudo tee -a "$HOSTS_FILE" > /dev/null
            echo "::1  $DOMAIN" | sudo tee -a "$HOSTS_FILE" > /dev/null
        fi
    else
        echo "$DOMAIN already present in $HOSTS_FILE."
    fi
done

# Check if the certificate file exists
if [ ! -f "$CERT_PATH" ]; then
    echo "Error: Certificate file not found at $CERT_PATH"
    exit 1
fi

echo "Adding certificate to Docker App Container..."
docker compose -f compose.yaml exec --user=root lanlist_app cp /var/www/html/caddy/data/caddy/pki/authorities/local/root.crt /usr/local/share/ca-certificates/
docker compose -f compose.yaml exec --user=root lanlist_app update-ca-certificates
echo "Certificate added to Docker App Container successfully."

# Add the certificate to the System keychain
echo "Adding certificate to System keychain..."

if [[ "$(uname)" == "Darwin" ]]; then
    sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain "$CERT_PATH"
else
    sudo cp "$CERT_PATH" /usr/local/share/ca-certificates/ || { echo "Failed to copy certificate."; exit 1; }
    sudo update-ca-certificates || { echo "Failed to update CA certificates."; exit 1; }
fi

echo "Certificate added successfully and marked as trusted."

# Ensure prepare-commit-msg git hook is installed and executable
GIT_HOOKS_DIR="$(pwd)/.git/hooks"
PREPARE_COMMIT_MSG_SRC="$(pwd)/scripts/prepare-commit-msg"
PREPARE_COMMIT_MSG_DEST="$GIT_HOOKS_DIR/prepare-commit-msg"

if [ ! -f "$PREPARE_COMMIT_MSG_DEST" ]; then
    echo "Installing prepare-commit-msg git hook..."

    if [ ! -d "$GIT_HOOKS_DIR" ]; then
        echo "Git hooks directory not found. Is this a git repository?"
        exit 1
    fi

    cp "$PREPARE_COMMIT_MSG_SRC" "$PREPARE_COMMIT_MSG_DEST" || { echo "Failed to copy prepare-commit-msg hook."; exit 1; }
    chmod +x "$PREPARE_COMMIT_MSG_DEST" || { echo "Failed to make prepare-commit-msg executable."; exit 1; }
    echo "prepare-commit-msg hook installed."
else
    echo "prepare-commit-msg git hook already exists."
fi
