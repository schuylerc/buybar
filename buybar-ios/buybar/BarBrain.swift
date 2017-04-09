//
//  BarBrain.swift
//  buybar
//
//  Created by Joshua Wagner on 4/8/17.
//  Copyright © 2017 Joshua Wagner. All rights reserved.
//

import Foundation
import Alamofire
import SwiftyJSON

class BarBrain {
    static var session_id = 0
    static var keys = ["client_id":"client_58e893bcdaa3258e893bcdaac9", "secret_key":"secret_edd35b8ec98a8a4fbf9be85c34"]
    static var menuItemsArray: [MenuItem] = []
    static var driversNumber = ""
    
    // checks in to bar by starting a session
    // assigns session id to variable in BarBrain
    static func startSession(sessionID: Int) {
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
    static func getMenuItems() {
        self.menuItemsArray = []
        let request = Alamofire.request("http://ec2-54-236-35-76.compute-1.amazonaws.com/api/v1/menu_items")
        request.authenticate(user: self.keys["client_id"]!, password: self.keys["secret_key"]!)
        request.responseJSON{
            response in switch(response.result){
            case .success:
                print("success")
                                print(response.result.value ?? "Error")
                let unpacked_json = JSON(response.result.value!)
                for (_, subJson) in unpacked_json{
                    print(subJson["title"])
                    self.menuItemsArray.append(MenuItem(n_id: Int(subJson["id"].stringValue)!, n_price: Int(subJson["price"].stringValue)!, n_title: subJson["title"].stringValue))
                }
                
            case .failure(let error):
                print("error: \(error)")
            }
        }
//        print("printing resultMenuArray")
//        print(resultMenuArray)
    }
    
    // sends order to server
    // sends id of order item and id of session
    static func sendOrder(itemToOrder: Int) {
         Alamofire.request("http://ec2-54-236-35-76.compute-1.amazonaws.com/api/v1", method: .post, parameters: ["session_id":self.session_id, "order_id":itemToOrder], encoding: URLEncoding.default).validate().responseJSON{
                    response in switch(response.result){
                    case .success:
                        print("success")
                    case .failure(let error):
                        print("error: \(error)")
                    }
                }
    }
    
    // closes out session
    static  func closeSession(){
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
