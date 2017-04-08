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

    static func setId(newId : String) {
        id = newId
    }
    
    static func getId() -> String {
        return id
    }
}
