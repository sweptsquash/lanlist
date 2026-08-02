# lanlist.org

A free and open list of LAN parties. It's provided purely for the benefit of the LAN party community.

## Development

### Prerequisites

- Docker Desktop (or Docker Engine) with Docker Compose
- Node.js LTS (for npm ci)
- Make (usually available by default on macOS/Linux; for Windows, use WSL2)
- Optional but helpful: Sail alias (Make targets call Sail directly, so not required)

### Setup Guide

*Note*: If you are using Windows, you will need to run the setup commands from WSL2, not PowerShell or CMD. The Makefile is designed to work in a Linux-like environment. Please also take note of the SSL & local domains section below for Windows users.

Use the Makefile for a consistent, repeatable setup:

```bash
make setup
```

That single command will:

- Create .env from .env.local.example (if missing)
- Install Composer dependencies (locally or via Docker)
- Install Node dependencies with npm ci
- Build and start Sail containers
- Generate the app key
- Reset and seed the database
- Generate IDE helper files
- Add local hosts entries and trust the local Caddy root certificate (Linux/macOS)

After setup, the app should be reachable at `https://lanlist.dev`

### Daily commands

- Start containers: `make sail_up`
- Stop containers: `make sail_stop` (or `make sail_down` to remove)
- Rebuild images: `make sail_build`
- Reset database and seed: `make db_reset`
- Clear and rebuild caches: `make clear_cache`
- Update Composer deps: `make composer_update`
- Generate IDE helpers: `make ide_helper`
- Setup SSL & hosts (idempotent): `make setup_ssl_hosts`
- Serve SPA: `make spa_serve`
- Show all targets and descriptions: `make help`

### Notes on SSL & local domains

The local reverse proxy (Caddy) issues a root CA and domain certificates for:

- `lanlist.dev`
- `ws.lanlist.dev`

During `make setup`, the script at `scripts/setup.sh`:

- Appends these domains to `/etc/hosts` (idempotent)
- Installs the generated root CA into the system trust store (Linux/macOS)

### Windows users (certificate trust)

When developing via WSL2, browsers on Windows use the Windows trust store, not WSL's. After the first `make sail_up` (which allows Caddy to generate its CA), import the Caddy root certificate into Windows:

Option A: GUI

- Open File Explorer to the project path from Windows: `\\wsl.testhost\Ubuntu-24.04\home\[USERNAME]\projects\lanlist\data\caddy\pki\authorities\local\root.crt`
- Double‑click `root.crt` → Install Certificate → Local Machine → Trusted Root Certification Authorities

Option B: PowerShell (Run as Administrator)

```powershell
certutil -addstore -f "Root" "\\wsl.testhost\Ubuntu-24.04\home\[USERNAME]\projects\lanlist\data\caddy\pki\authorities\local\root.crt"
```

If you access the app from Windows browsers, ensure the certificate is trusted in Windows. The Linux/WSL trust is handled by `make setup`.

## Troubleshooting

- Containers won't start: run `make sail_down` then `make sail_up`, or `make sail_build` if images changed.
- SSL errors in Windows browsers: (1) Start containers once so Caddy generates the CA, then (2) import `caddy/data/caddy/pki/authorities/local/root.crt` into Windows as above.
- Vite or asset issues: run `npm ci` (if needed) and `npm run build`.
- Laravel caches stale: run `make clear_cache`.

## Advanced

If you prefer manual steps or need to iterate on one part, the Make targets simply wrap these common actions. You can inspect and extend them in the Makefile. For a full list with descriptions, run:

```bash
make help
```
