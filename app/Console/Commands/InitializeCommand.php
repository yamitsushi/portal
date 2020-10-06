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
        $interface="wlan0";
        $ipv4="10.0.0.1/20";
        $range="10.0.0.11, 10.0.15.250 ,255.255.240.0,24h";
        $country_code="PH";
        $driver="nl80211";
        $ssid="Yamit Piso Wifi";
        $hw_mode="g";
        $channel="7";


        //symlink connect to portal
        shell_exec("sudo ln -s /var/www/portal ". base_path());

        //install hostapd
        shell_exec("sudo apt install hostapd");

        //enable hostapd
        shell_exec("sudo systemctl unmask hostapd");
        shell_exec("sudo systemctl enable hostapd");

        //install dnsmasq
        shell_exec("sudo apt install dnsmasq");

        //persistent iptable
        shell_exec("sudo DEBIAN_FRONTEND=noninteractive apt install -y netfilter-persistent iptables-persistent");

        //append dhcpcd
        shell_exec("echo 'interface '". $interface ." >> /etc/dhcpcd.conf");
        shell_exec("echo 'static ip_address=". $ipv4 ."' >> /etc/dhcpcd.conf");
        shell_exec("echo 'nohook wpa_supplicant' >> /etc/dhcpcd.conf");

        //enable routing
        shell_exec("echo 'net.ipv4.ip_forward=1' >> /etc/sysctl.d/routed-ap.conf");

        //mask all routes
        shell_exec("sudo iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE");

        //save changes
        shell_exec("sudo netfilter-persistent save");




        //configure dhcp server
        shell_exec("echo 'interface=". $interface . "' >> /etc/dnsmasq.conf");
        shell_exec("echo 'dhcp-range=". $range ."' >> /etc/dnsmasq.conf");


        //unblock wlan
        shell_exec("sudo rfkill unblock wlan");


        shell_exec("echo 'country_code=". $country_code ."' >> /etc/hostapd/hostapd.conf");
        shell_exec("echo 'driver=". $driver ."' >> /etc/hostapd/hostapd.conf");
        shell_exec("echo 'ssid=". $ssid ."' >> /etc/hostapd/hostapd.conf");
        shell_exec("echo 'hw_mode=". $hw_mode ."' >> /etc/hostapd/hostapd.conf");
        shell_exec("echo 'channel=". $channel ."' >> /etc/hostapd/hostapd.conf");

        shell_exec("sudo systemctl reboot");
    }
}