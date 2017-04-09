#!/usr/bin/env python
# encoding: utf-8

"""
sentrydl.parser
~~~~~~~~~~~~~~~

This modules contains the the Drivers License parsing code.

"""

import re
import datetime
from datetime import timedelta
from dateutil.relativedelta import *

class CouldNotParseError(RuntimeError):
    """The license text could not be parsed."""
    def __to_str__(self):
        return 'The license text could not be parsed.'


class License(object):
    """
    Parse and represent a Drivers License or Non-Driver Identification Card.
    """
    def __init__(self, raw_license_text):
        self._raw = raw_license_text

        self._dob = None
        self._age = None

        self._first_name = None
        self._middle_name = None
        self._last_name = None
        self._name = None
        self._standard_name = None

        self._date_issued = None
        self._expiration_date = None

        self._street1 = None
        self._city = None
        self._state = None
        self._zip = None
        self._address = None

        self._customer_identifier = None
        self._eyes = None
        self._sex = None
        self._height = None

        self._vehicle_class = None
        self._endorsements = None
        self._restrictions = None


    def raw_license_text(self):
        """Return the raw license text."""
        return self._raw


    def date_of_birth(self):
        """Return the date of birth from the Drivers License."""
        if not self._dob:  # date of birth has not been parsed yet
            dob = re.search("DBB([0-9]{8})D", self._raw).group(1)
            self._dob = datetime.date(int(dob[4:]), int(dob[0:2]),
                                      int(dob[2:4]))
        return self._dob

    def is_over_21(self):
        """Return whether the customer is over 21."""
        return self.age() >= 21

    def is_over_18(self):
        """Return whether the customer is over 18."""
        return self.age() >= 18


    def age(self):
        if not self._age:
            today = datetime.date.today()
            self._age=relativedelta(today, self.date_of_birth()).years
        return self._age


    def expiration_date(self):
        """Return the expiration date of the Drivers License."""
        if not self._expiration_date:  # expiration date has not been parsed
            dob = re.search("DBA([0-9]{8})D", self._raw).group(1)
            self._expiration_date = datetime.date(int(dob[4:]), int(dob[0:2]),
                                                  int(dob[2:4]))
        return self._expiration_date

    def is_expired(self):
        """
        Return True if the Drivers License is expired. Otherwise, return false.
        """
        return relativedelta(datetime.date.today(), self.expiration_date()).years > 0


    def first_name(self):
        if not self._first_name:
            first_name_search = re.search("DCT(\\w{0,40})[,\\s]", self._raw)
            self._first_name = first_name_search.group(1).strip()
        return self._first_name


    def middle_name(self):
        if not self._middle_name:
            middle_name_search = re.search("DCT(.*?),(\\w{0,40})[,\\s]",
                                           self._raw)
            self._middle_name = middle_name_search.group(2).strip()
        return self._middle_name


    def last_name(self):
        """Return the last name parsed from the Drivers License."""
        if not self._last_name:  # last name has not been parsed yet
            last_name_search = re.search("DCS(.{0,40})D", self._raw)
            self._last_name = last_name_search.group(1).strip()
        return self._last_name


    def name(self):
        if not self._name:
            self._name = "{0} {1} {2}".format(self.first_name(),
                                              self.middle_name(),
                                              self.last_name())
        return self._name


    def standard_name(self):
        if not self._standard_name:
            self._standard_name = "{2}, {0} {1}.".format(self.first_name(),
                                                         self.middle_name()[0],
                                                         self.last_name())
        return self._standard_name


    def street_address(self):
        if not self._street1:
            street_search = re.search("DAG(.{0,35})D", self._raw)
            self._street1 = street_search.group(1).strip()
        return self._street1


    def state(self):
        if not self._state:
            self._state = re.search("DAJ([A-Z]{2})", self._raw).group(1)
        return self._state


    def city(self):
        if not self._city:
            self._city = re.search("DAI(.{0,20})D", self._raw).group(1).strip()
        return self._city


    def zip_code(self):
        if not self._zip:
            self._zip = re.search("DAK(.{11})D", self._raw).group(1).strip()
        return self._zip


    def address(self):
        if not self._address:
            self._address = "{0}, {1} {2} {3}".format(self.street_address(),
                                                      self.city(), self.state(),
                                                      self.zip_code()[:5])
        return self._address


    def date_issued(self):
        if not self._date_issued:
            date_issued = re.search("DBD([0-9]{8})D", self._raw).group(1)
            self._date_issued = datetime.date(int(date_issued[4:]),
                                              int(date_issued[0:2]),
                                              int(date_issued[2:4]))
        return self._date_issued


    def customer_identifier(self):
        if not self._customer_identifier:
            customer_id = re.search("DAQ(\\w{0,25})", self._raw)
            self._customer_identifier = customer_id.group(1).strip()
        return self._customer_identifier


    def sex(self):
        if not self._sex:
            gender_num = int(re.search("DBC([12])", self._raw).group(1))
            if gender_num == 1:
                self._sex = "male"
            elif gender_num == 2:
                self._sex = "female"
        return self._sex


    def eyes(self):
        if not self._eyes:
            self._eyes = re.search("DAY(\\w{3})", self._raw).group(1).strip()
        return self._eyes


    def height(self):
        if not self._height:
            self._height = re.search("DAU(.{6})", self._raw).group(1)
        return self._height


    def vehicle_class(self):
        if not self._vehicle_class:
            vehicle_class_search = re.search("DCA(\\w{0,6})[D|\\s|]",
                                             self._raw)
            self._vehicle_class = vehicle_class_search.group(1).strip()
        return self._vehicle_class


    def endorsements(self):
        if not self._endorsements:
            endorsements_search = re.search("DCD(\\w{0,5})[D|\\s|]", self._raw)
            self._endorsements = endorsements_search.group(1).strip()
        return self._endorsements


    def restrictions(self):
        if not self._restrictions:
            restrictions_search = re.search("DCB(\\w{0,12})[D|\\s|]",
                                            self._raw)
            self._restrictions = restrictions_search.group(1).strip()
        return self._restrictions
