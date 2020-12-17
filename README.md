# Cloudflare_DNS_Updater
A simple PHP script that will update your DNS Record(s) through Cloudflare API

This script uses the API found at myip.com to fetch your current IP, when changes happen your new IP will be written to a text file that are compared against the API at myip.com, and only when change is detected this will update your Record through the Cloudflare API.
