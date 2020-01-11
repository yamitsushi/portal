import RPi.GPIO as GPIO
import subprocess
import signal
import time

process = []

def pulse_callback(channel):
	global process
	global cleaning
	print('detected')
	pulse = subprocess.Popen(["php", "artisan", "pulse:generate"])
	process.append(pulse)

GPIO.setmode(GPIO.BOARD)
GPIO.setup(7, GPIO.IN, pull_up_down=GPIO.PUD_DOWN)
GPIO.add_event_detect(7, GPIO.RISING, callback=pulse_callback)



try:
	while True:
		time.sleep(1)
		if process:
			process[:] = [child for child in process if child.poll() is None]
			print("Still running: %s" % [popen.pid for popen in process])
	signal.pause()
finally:
	GPIO.cleanup()
