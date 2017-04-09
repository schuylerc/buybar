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

        r = requests.post("http://ec2-54-236-35-76.compute-1.amazonaws.com", json=(ret))
        print(r.json())

        return json.dumps(ret)
    return "OK"
if __name__ == '__main__':
    print('')
    app.debug=True
    app.run(host='0.0.0.0', port=25566)
