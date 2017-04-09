//
//  ConfirmOrderViewController.swift
//  buybar
//
//  Created by Joshua Wagner on 4/9/17.
//  Copyright © 2017 Joshua Wagner. All rights reserved.
//

import UIKit

class ConfirmOrderViewController: UIViewController {

    @IBOutlet weak var okButton: UIButton!
    @IBOutlet weak var yourOrderLabel: UILabel!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        okButton.backgroundColor = UIColor.gray
//        okButton.setTitleColor(.white, for: .normal)
        self.view.backgroundColor = UIColor.black
        yourOrderLabel.text = "Your order is number " + BarBrain.orderNumber
        // Do any additional setup after loading the view.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    

    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
    }
    */

}
