import threading
import subprocess
import signal
import json

def startMonitor():
    threading.Timer(5, startMonitor).start()
    raw = open('storage/app/list.json')
    list = json.load(raw)
    for line in list:
        temp = list[line]
        response = subprocess.call(['ping','-c','1',temp[1]], stdout=subprocess.PIPE)
        if response != 0:
            subprocess.call(["php", "artisan", "portal:disable", temp[0], temp[1]], stdout=subprocess.PIPE)

def startTester():
    threading.Timer(10, startTester).start()
    response = subprocess.call(['ping','-c','1', '8.8.8.8'], stdout=subprocess.PIPE)
    if response != 0:
        raw = open('storage/app/list.json')
        list = json.load(raw)
        for line in list:
            subprocess.call(["php", "artisan", "portal:disable", temp[0], temp[1]], stdout=subprocess.PIPE)


try:
    startMonitor()
    startTester();
    signal.pause()
finally:
    print("program terminated")
