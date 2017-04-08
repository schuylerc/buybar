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
    //    var keys = ["":"", "":""]
    
    // checks in to bar by starting a session
    // assigns session id to variable in BarBrain
    func startSession(sessionID: Int) {
        self.session_id = sessionID
        //        Alamofire.request("", method: .post, encoding: URLEncoding.default).validate().responseJSON{
        //            response in switch(response.result){
        //            case .success:
        //                print("success")
        //            case .failure(let error):
        //                print("error: \(error)")
        //            }
        //        }
    }
    
    // gets all available menu items and returns them as a dictionary containing [item: price]
    func getMenuItems() -> [String: String] {
        Alamofire.request("https://httpbin.org/get").validate().responseJSON{
            response in switch(response.result){
            case .success:
                print("success")
                print(response.result.value)
            case .failure(let error):
                print("error: \(error)")
            }
        }
        return ["": ""]
    }
    
    // sends order to server
    // sends id of order item and id of session
    func sendOrder(itemToOrder: String) {
        //        Alamofire.request("", method: .post, encoding: URLEncoding.default).validate().responseJSON{
        //            response in switch(response.result){
        //            case .success:
        //                print("success")
        //            case .failure(let error):
        //                print("error: \(error)")
        //            }
        //        }
    }
    
    // closes out session
    func closeSession(){
        //        Alamofire.request("", method: .post, encoding: URLEncoding.default).validate().responseJSON{
        //            response in switch(response.result){
        //            case .success:
        //                print("success")
        //            case .failure(let error):
        //                print("error: \(error)")
        //            }
        //        }
    }
    
    
    
}
