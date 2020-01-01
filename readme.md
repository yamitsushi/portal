## About Portal

Portal is a Captive Portal that runs on a raspberry pi.

This is an open source and a project someone ask me to try and make.

The development of this project is a scattered one, so do not expect this project to have a good documentation and efficient coding style.

## Prerequisite

- get all updates
```
sudo apt-get update
sudo apt-get upgrade -y
```
- install required library
```
sudo apt-get install hostapd dnsmasq composer git php7.3 php7.3-bcmath php7.3-common php7.3-json php7.3-mbstring php7.3-xml php7.3-curl -y
```
- add following line at the bottom of  /etc/dhcpcd.conf
```
interface wlan0
    static ip_address=10.0.0.1/20
    nohook wpa_supplicant
```

- save the following line at /etc/hostapd/hostapd.conf
```
interface=wlan0
driver=nl80211

hw_mode=g
channel=1

ssid=Pi3-AP
```

- update /etc/default/hostapd
```
#DAEMON_CONF=""
```
to
```
DAEMON_CONF="/etc/hostapd/hostapd.conf"
```

- overwrite /etc/dnsmasq.conf with
```
interface=wlan0
dhcp-range=10.0.0.11,10.0.15.254, 255.255.240.0,12h
```

- update /etc/sysctl.conf
```
#net.ipv4.ip_forward=1
```
to
```
net.ipv4.ip_forward=1
```

- initiate iptable
```
iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE
iptables -N OUT -t nat
iptables -t nat -A PREROUTING -i wlan0 -j OUT
iptables -t nat -A OUT -m mark --mark 99 -j RETURN
iptables -t nat -A OUT -p tcp --dport 80 -j DNAT --to-destination 10.0.0.1
iptables -N OUT -t mangle
iptables -t mangle -A PREROUTING -i wlan0 -j OUT
iptables -N NET -t filter
iptables -t filter -A FORWARD -i wlan0 -j NET
iptables -t filter -A NET -m mark --mark 99 -j ACCEPT
iptables -t filter -A NET -j DROP
```

- run this command
```
sudo sh -c "iptables-save > /etc/iptables.ipv4.nat"
```

- add the folowing line just above 'exit 0' in /etc/rc.local
```
iptables-restore < /etc/iptables.ipv4.nat
```

- clone this repository in /var/www/

- run this command inside the portal
```
composer install
cp .env.example .env
composer install
php artisan key:generate
touch database/database.sqlite
chmod -R 777 storage
```

- create file at /etc/apache2/sites-available/laravel.conf with the following content
```
<VirtualHost *:80>
    ServerName portal.com

    ServerAdmin webmaster@portal.com
    DocumentRoot /var/www/portal/public

    <Directory /var/www/portal>
        AllowOverride All
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

- run this command
```
sudo a2dissite 000-default.conf
sudo a2ensite laravel.conf
sudo a2enmod rewrite
sudo service apache2 restart
```

- update .env with prefered data
```
APP_ENV=prod
APP_URL=http://portal.com
```

# To be Continued

## Running Portal
To Be Followed

## License

The Portal is Licensed under the [MIT license](https://opensource.org/licenses/MIT).
