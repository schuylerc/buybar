//
//  SessionId.swift
//  buybar
//
//  Created by iostest on 4/8/17.
//  Copyright © 2017 Joshua Wagner. All rights reserved.
//

import Foundation

class SessionId {
    
    static var id = ""
    static var email = ""
    static var phoneNumber = ""

    static func setId(newId : String) {
        id = newId
    }
    
    static func getId() -> String {
        return id
    }
    
    static func setEmail(newEmail : String) {
        email = newEmail
    }
    
    static func getEmail() -> String {
        return email
    }
    
    static func setPhoneNumber(newPhoneNumber : String) {
        phoneNumber = newPhoneNumber
    }
    
    static func getPhoneNumber() -> String {
        return phoneNumber
    }
}
