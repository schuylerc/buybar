//
//  BarBrain.swift
//  buybar
//
//  Created by Joshua Wagner on 4/8/17.
//  Copyright © 2017 Joshua Wagner. All rights reserved.
//

import Foundation
import Alamofire

class BarBrain {
    var session_id = 0
    
    // checks in to bar by starting a session
    // assigns session id to variable in BarBrain
    func startSession(sessionID: Int) {
        self.session_id = sessionID
    }
    
    // gets all available menu items and returns them as a dictionary containing [item: price]
    func getMenuItems() -> [String: String] {
        return ["": ""]
    }
    
    // sends order to server
    func sendOrder(itemToOrder: String) {
        
    }
    
    // closes out session
    func closeSession(){
        
    }
    
    
    
}
