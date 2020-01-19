import RPi.GPIO as GPIO
import threading
import subprocess
import signal

thread = []

def pulse_callback(channel):
    global thread
    pulse = subprocess.Popen(["php", "artisan", "portal:pulse"], stdout=subprocess.PIPE)
    thread.append(pulse)


def startTerminator():
    threading.Timer(1, startTerminator).start()
    global thread
    if thread:
        thread[:] = [child for child in thread if child.poll() is None]
    print "Still running: %s" % [popen.pid for popen in thread]


try:
    GPIO.cleanup()
    GPIO.setmode(GPIO.BOARD)
    GPIO.setup(7, GPIO.IN, pull_up_down=GPIO.PUD_UP)
    GPIO.add_event_detect(7, GPIO.FALLING, callback=pulse_callback)
    startTerminator()
    signal.pause()
finally:
    GPIO.cleanup()
