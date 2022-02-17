# -*- coding: UTF-8 -*-


from difflib import SequenceMatcher
import mysql.connector
import os
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

def generate_all_file(tableSmall,tableBig):
    with open('view_sample/all_sample.txt') as f:
        text = f.read()

    new_file_text = text.replace('brand', tableSmall)
    new_file_text = new_file_text.replace('Brand', tableBig)
    print(new_file_text)
    path = "viewCi4/" + tableSmall
    os.makedirs(path, exist_ok=True)

    f = open(path+ "/all.php", "w+")
    f.write(new_file_text)
    f.close()

def generate_add_file(tableSmall,tableBig):
    with open('view_sample/add_sample.txt') as f:
        text = f.read()

    new_file_text = text.replace('brand', tableSmall)
    new_file_text = new_file_text.replace('Brand', tableBig)
    print(new_file_text)
    path = "viewCi4/" + tableSmall
    os.makedirs(path, exist_ok=True)

    f = open(path+ "/add.php", "w+")
    f.write(new_file_text)
    f.close()

def generate_edit_file(tableSmall, tableBig):
    with open('view_sample/edit_sample.txt') as f:
        text = f.read()

    new_file_text = text.replace('brand', tableSmall)
    new_file_text = new_file_text.replace('Brand', tableBig)
    print(new_file_text)
    path = "viewCi4/" + tableSmall
    os.makedirs(path, exist_ok=True)

    f = open(path + "/edit.php", "w+")
    f.write(new_file_text)
    f.close()

def generate_detail(tableSmall, tableBig):
    with open('view_sample/detail_sample.txt') as f:
        text = f.read()

    new_file_text = text.replace('brand', tableSmall)
    new_file_text = new_file_text.replace('Brand', tableBig)
    print(new_file_text)
    path = "viewCi4/" + tableSmall
    os.makedirs(path, exist_ok=True)

    f = open(path + "/detail.php", "w+")
    f.write(new_file_text)
    f.close()



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

        generate_all_file(small_letter_name,tableNameClean)
        generate_add_file(small_letter_name,tableNameClean)
        generate_edit_file(small_letter_name,tableNameClean)
        generate_detail(small_letter_name,tableNameClean)

    # print(text)
    # f = open("controller/"+controllerName, "w+")
    # f.write(text)
    # f.close()





