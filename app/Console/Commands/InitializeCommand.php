<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InitializeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portal:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialized System';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user="pi";
        $interface="wlan0";
        $ipv4="10.0.0.1/20";
        $range="10.0.0.11, 10.0.15.250 ,255.255.240.0,24h";
        $country_code="PH";
        $driver="nl80211";
        $ssid="Yamit Piso Wifi";
        $hw_mode="g";
        $channel="7";


        //symlink connect to portal
        shell_exec("sudo ln -s ". base_path() ."/var/www/portal ");
        shell_exec("sudo chown -R www-data:www-data " . base_path() ."/storage");
        shell_exec("sudo chown -R www-data:www-data " . base_path() ."/database");
        shell_exec("sudo usermod -a -G www-data " . $user);

        //cron task
        shell_exec("(crontab -l ; echo \"* * * * * cd /var/www/portal && php artisan schedule:run >> /dev/null 2>&1\") | crontab -");


        //install supervisor
        shell_exec("sudo apt install supervisor -y");
        shell_exec("sudo cp ". base_path() ."/config/extra/websockets.conf /etc/supervisor/conf.d/");
        shell_exec("sudo cp ". base_path() ."/config/extra/pulser.conf /etc/supervisor/conf.d/");

        //website
        shell_exec("sudo cp ". base_path() ."/config/extra/laravel.conf /etc/apache2/sites-available/");
        shell_exec("sudo a2ensite laravel");
        shell_exec("sudo a2enmod rewrite");

        //install hostapd
        shell_exec("sudo apt install hostapd -y");

        //enable hostapd
        shell_exec("sudo systemctl unmask hostapd");
        shell_exec("sudo systemctl enable hostapd");
        shell_exec("sudo bash -c \"echo 'DAEMON_CONF=\\\"/etc/hostapd/hostapd.conf\\\"' >> /etc/default/hostapd\"");

        //install dnsmasq
        shell_exec("sudo apt install dnsmasq -y");

        //persistent iptable
        shell_exec("sudo DEBIAN_FRONTEND=noninteractive apt install netfilter-persistent iptables-persistent -y");

        //append dhcpcd
        shell_exec("sudo echo 'interface '". $interface ." >> /etc/dhcpcd.conf");
        shell_exec("sudo echo 'static ip_address=". $ipv4 ."' >> /etc/dhcpcd.conf");
        shell_exec("sudo echo 'nohook wpa_supplicant' >> /etc/dhcpcd.conf");

        //enable routing
        shell_exec("sudo bash -c \"echo 'net.ipv4.ip_forward=1' >> /etc/sysctl.d/routed-ap.conf\"");

        //test marks
        shell_exec("sudo iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE");

        shell_exec("sudo iptables -N internet -t mangle");
        shell_exec("sudo iptables -t mangle -A PREROUTING -i wlan0 -j internet");
        shell_exec("sudo iptables -t mangle -A internet -j MARK --set-mark 99");
        shell_exec("sudo iptables -t nat -A PREROUTING -m mark --mark 99 -p tcp --dport 80 -j DNAT --to-destination 10.0.0.1");
        shell_exec("sudo iptables -t filter -A FORWARD -m mark --mark 99 -j DROP");
        //save changes
        shell_exec("sudo netfilter-persistent save");


        //rmtrack command
        shell_exec("sudo apt install conntrack -y");
        shell_exec("sudo cp ". base_path() ."/config/extra/rmtrack /usr/sbin/");


        //configure dhcp server
        shell_exec("sudo bash -c \"echo 'interface=". $interface . "' >> /etc/dnsmasq.conf\"");
        shell_exec("sudo bash -c \"echo 'dhcp-range=". $range ."' >> /etc/dnsmasq.conf\"");
        shell_exec("sudo bash -c \"echo 'address=/portal.host/10.0.0.1' >> /etc/dnsmasq.conf\"");


        //unblock wlan
        shell_exec("sudo rfkill unblock wlan");


        shell_exec("sudo bash -c \"echo 'interface=". $interface ."' >> /etc/hostapd/hostapd.conf\"");
        shell_exec("sudo bash -c \"echo 'country_code=". $country_code ."' >> /etc/hostapd/hostapd.conf\"");
        shell_exec("sudo bash -c \"echo 'driver=". $driver ."' >> /etc/hostapd/hostapd.conf\"");
        shell_exec("sudo bash -c \"echo 'ssid=". $ssid ."' >> /etc/hostapd/hostapd.conf\"");
        shell_exec("sudo bash -c \"echo 'hw_mode=". $hw_mode ."' >> /etc/hostapd/hostapd.conf\"");
        shell_exec("sudo bash -c \"echo 'channel=". $channel ."' >> /etc/hostapd/hostapd.conf\"");


        shell_exec("sudo systemctl reboot");
    }
}

