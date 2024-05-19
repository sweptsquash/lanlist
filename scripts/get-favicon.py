#!/usr/bin/env python

import mysql.connector
import os
import requests
from bs4 import BeautifulSoup

def downloadFavicon(url, site, orgId):
    res = requests.get(site + url)

    print("\t", res.status_code, url)

    if res.status_code == 200:
        with open(str(orgId) + '.ico', 'wb') as f:
            f.write(res.content)

    if res.status_code == 200:
        return True
    else:
        return False

def findFavicon(site, orgId):
    print("\tTrying to find favicon for ", site)

    res = requests.get(site)
    res.raise_for_status()

    soup = BeautifulSoup(res.content, features = "lxml")
    
    for link in soup.find_all('link'):
        if "icon" in link['rel']:
            print("\tFound a favicon!")
            downloadFavicon(link['href'], site, orgId)
            return

    print ("\tCould not find a favicon")

mydb = mysql.connector.connect(
    host = 'localhost',
    user = os.environ['MYSQL_USER'],
    password = os.environ['MYSQL_PASS'],
    database = 'lanlist',
)

cur = mydb.cursor()
cur.execute('SELECT o.websiteUrl, o.id FROM organizers o')

testData = [
    ("https://blog.jread.com", "0")
]

for row in cur:
    try: 
        print("Getting ", row[0])

        if not downloadFavicon('/favicon.ico', row[0], row[1]):
            findFavicon(row[0], row[1])

    except Exception as e:
        print("\tExcept", e, row[0])
