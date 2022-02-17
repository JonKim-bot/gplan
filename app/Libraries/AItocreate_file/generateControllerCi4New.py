# -*- coding: UTF-8 -*-


from difflib import SequenceMatcher
import mysql.connector

import os
# arr = os.listdir("C:\\xampp\\htdocs\\galaeats\\application\\controllers")
import datetime
import turtle
import os

print(datetime.datetime.now())
conn = mysql.connector.connect(
    user='root',
    password='password',
    host='127.0.0.1',
    database='carlink')
mycursor = conn.cursor((mysql.connector).connect.__dict__)
# mycursor.execute("SHOW TABLES LIKE '%_log%'") # using excure function to show the tabkes;

mycursor.execute("SHOW TABLES")
# using excure function to show the tabkes;
resultAll = [item[0] for item in mycursor.fetchall()]
resultWithoutlog = []


def cap(str):
    return str.charAt(0).toUpperCase() + str.slice(1).replace('/ _/', ':')


for tables in resultAll:
    if (tables.endswith("_log")):
        # print("All log tables")
        print()
    else:
        #        run the create file function here
        tablesCap = str(tables.capitalize())
        # print(tablesCap)
        small_letter_name = tablesCap.lower()
        if ("_" in tablesCap):
            # Booking_request
            tableNameArr = tablesCap.replace("_", " ")

            tableNameClean = tableNameArr.title()
            tableNameClean = tableNameClean.replace(" ", "")

            print(tableNameClean + "tablename calan")

        else:
            tableNameClean = tablesCap
            # Booking[0]
            # request[0]
        print("create file")
        with open('sample_controller.txt') as f:
            text = f.read()

        # print(text)
        # print(tableNameClean)

        new_file_text = text.replace('brand',small_letter_name)
        new_file_text = new_file_text.replace('Brand',tableNameClean)
        print(new_file_text)
        controllerName = str(tableNameClean) + ".php"

        # if file not created
        print(controllerName + " not in arr")
        # print(text)
        f = open("controllerCi4/" + controllerName, "w+")
        f.write(new_file_text)  
        f.close()

    # print(text)
    # f = open("controller/"+controllerName, "w+")
    # f.write(text)
    # f.close()





