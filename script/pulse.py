import RPi.GPIO as GPIO
import threading
import subprocess
import signal

count=0
running=False

GPIO.cleanup()
GPIO.setmode(GPIO.BOARD)
GPIO.setup(7, GPIO.IN, pull_up_down=GPIO.PUD_UP)
GPIO.add_event_detect(7, GPIO.FALLING, callback=pulse_callback)

def pulse_callback(channel):
    global count, running
    if count and not running:
        running = True
        threading.Timer(1, send_pulse).start()

def send_pulse():
    global count, running
    pulse = count
    count= count - pulse
    running = False
    subprocess.call(["php", "artisan", "portal:pulse", pulse], stdout=subprocess.PIPE)

try:
    GPIO.cleanup()
    GPIO.setmode(GPIO.BOARD)
    GPIO.setup(7, GPIO.IN, pull_up_down=GPIO.PUD_UP)
    GPIO.add_event_detect(7, GPIO.FALLING, callback=pulse_callback)
    startTerminator()
    signal.pause()
finally:
    GPIO.cleanup()