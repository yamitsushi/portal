import threading
import subprocess
import signal
import sys

mac = sys.argv[1]
ip = sys.argv[2]

def startMonitor():
    global ip, mac
    response = subprocess.call(['ping','-c','1',ip], stdout=subprocess.PIPE)
    if response == 0:
        threading.Timer(1, startMonitor).start()
    else:
        subprocess.call(["php", "../artisan", "portal:disable", mac, "--monitor"], stdout=subprocess.PIPE)
        sys.exit("Client not found")

try:
    startMonitor()
    signal.pause()
finally:
    print("program terminated")
