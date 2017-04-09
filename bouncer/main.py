#!/usr/bin/env python
# -*- coding: utf-8 -*-

from flask import Flask, request
import requests
import json

from parser import *

app = Flask(__name__)

#mother_url=


@app.route("/flask", methods=["GET", "POST"])
def flask():
    if request.method == "POST":

        print("Printing Details")

        try:
            print("JSON:")
            print(request.get_json())
        except:
            print("CANNOT PRINT")
        try:
            print("TEXT:")
            print(request.text)
        except:
            print("CANNOT PRINT")
        try:
            print("HEADERS")
            print(request.headers["content-type"])
        except:
            print("CANNOT PRINT")

        if request.headers["content-type"] not "application/json":
            return "401"

        print("BEGIN PROCESSING")
        data=request.get_json()["data"]
        l = License(data)
        ret={}
        ret["raw_license_text"] = l.raw_license_text()
        ret["date_of_birth"] = str(l.date_of_birth())
        ret["is_over_21"] = l.is_over_21()
        ret["is_over_18"] = l.is_over_18()
        ret["age"] = l.age()
        ret["expiration_date"] = str(l.expiration_date())
        ret["is_expired"] = l.is_expired()
        ret["first_name"] = l.first_name()
        ret["middle_name"] = l.middle_name()
        ret["last_name"] = l.last_name()
        ret["name"] = l.name()
        ret["standard_name"] = l.standard_name()
        ret["street_address"] = l.street_address()
        ret["state"] = l.state()
        ret["city"] = l.city()
        ret["zip_code"] = l.zip_code()
        ret["address"] = l.address()
        ret["date_issued"] = str(l.date_issued())
        ret["customer_identifier"] = l.customer_identifier()
        ret["sex"] = l.sex()
        ret["eyes"] = l.eyes()
        ret["height"] = l.height()
        ret["vehicle_class"] = l.vehicle_class()
        ret["endorsements"] = l.endorsements()
        ret["restrictions"] = l.restrictions()

        print("PROCESSED JSON")
        print(ret)
        print("Posting:")
        client_id="client_58e893bcdaa3258e893bcdaac9"
        secret="secret_edd35b8ec98a8a4fbf9be85c34"
        p = request.get_json()["pass"]
        if p == "True":
            r = requests.post("http://ec2-54-236-35-76.compute-1.amazonaws.com/api/v1/sessions", data=(ret), auth=(client_id, secret))
            print("RESULTS:")
            print(r)
            try:
                print("JSON:")
                print(r.json())
            except:
                print("TEXT:")
                print(r.text)
            print("Returning")
        ret["id_code"] = ret["customer_identifier"]
        ret["session_id"] = requests.post("http://ec2-54-236-35-76.compute-1.amazonaws.com/api/v1/locate_session", data=ret, auth=(client_id, secret)).json()
        print("RETURNING SUCCESSFULLY")
        return json.dumps(ret)

    return "OK"
if __name__ == '__main__':
    print('')
    app.debug=True
    app.run(host='0.0.0.0', port=25566)
