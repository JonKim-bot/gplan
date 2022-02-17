# -*- coding: UTF-8 -*-


from difflib import SequenceMatcher
import mysql.connector

import os
# arr = os.listdir("C:\\xampp\\htdocs\\galaeats\\application\\models")
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
    if(tables.endswith("_log")):
        # print("All log tables")
        print()
    else:
 #        run the create file function here
        tablesCap = str(tables.capitalize())
        if("_" in tablesCap):
            #Booking_request
            tableNameArr = tablesCap.replace("_"," ")
            tableNameClean = tableNameArr.title()
            tableNameClean = tableNameClean.replace(" ","")
            print(tableNameClean + "tablename calan")

        else:
            tableNameClean = tablesCap
            #Booking[0]
            #request[0]
        print("create file")
        text = '<?php namespace App\Models;\n\nuse App\Core\BaseModel;\n\nclass ' + str(tableNameClean) + 'Model extends BaseModel{\n\n\tfunction __construct(){\n\n\t\tparent::__construct();\n\t\t$this->table_name = "'+str(tables)+'";\n\t\t$this->primary_key = "'+str(tables)+"_id"+'";\n\t}\n}\n?>'
        modelName = str(tableNameClean) + "Model.php"

        # if file not created
        print(modelName + " not in arr")
        print(text)
        f = open("modelCi4/"+modelName, "w+")
        f.write(text)
        f.close()

    # print(text)
        # f = open("model/"+modelName, "w+")
        # f.write(text)
        # f.close()





