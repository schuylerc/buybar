//
//  MenuItem.swift
//  buybar
//
//  Created by Joshua Wagner on 4/8/17.
//  Copyright © 2017 Joshua Wagner. All rights reserved.
//

import Foundation

class MenuItem{
    var id: Int
    var price: Int
    var title: String
    
    init(n_id: Int, n_price: Int, n_title: String) {
        self.id = n_id
        self.price = n_price
        self.title = n_title
    }
    
    
}
