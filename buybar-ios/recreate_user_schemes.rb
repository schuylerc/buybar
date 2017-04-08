#!/usr/bin/env ruby
require 'xcodeproj'
xcproj = Xcodeproj::Project.open("buybar.xcodeproj")
xcproj.recreate_user_schemes
xcproj.save

