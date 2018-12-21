#!/usr/bin/python
import serial
import time
import mysql.connector
	
conn = mysql.connector.connect(
         user='techno',
         password='techno',
         host='localhost',
         database='ts5')

cur = conn.cursor()

arduino=serial.Serial('/dev/ttyUSB0',baudrate=9600, timeout = 0.5)
cadena=''
idBascula=1
while True:
      
      while arduino.inWaiting() > 0:
								cadena += arduino.readline()
								cur.execute("INSERT INTO registro_basculas (Gramos,idBascula) VALUES (%s,%s);",(cadena[2:9],idBascula))
								conn.commit()
								print cadena[2:9]
								cadena=''
								
	    
arduino.close()
cur.close()
conn.close()