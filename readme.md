## About Portal

Portal is a Captive Portal that runs on a raspberry pi.

This is an open source and a project someone ask me to try and make.

The development of this project is a scattered one, so do not expect this project to have a good documentation and efficient coding style.

## Running Portal

initiate iptable
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
note that the script above assumes that the ip address for your captive portal is '10.0.0.1'

To Be Followed

## License

The Portal is Licensed under the [MIT license](https://opensource.org/licenses/MIT).
