//
//  ViewEmailController.swift
//  buybar
//
//  Created by iostest on 4/8/17.
//  Copyright © 2017 Joshua Wagner. All rights reserved.
//

import UIKit

class EmailViewController: UIViewController {

    @IBOutlet weak var email: UITextField!
    @IBOutlet weak var phoneNumber: UITextField!
    
    @IBAction func submit(_ sender: UIButton) {
        guard let eml = email.text else {
            print("email not available")
            return
        }
        
        guard let phn = phoneNumber.text else {
            print("phoneNumber not available")
            return
        }
        
        SessionId.setEmail(newEmail: eml)
        SessionId.setPhoneNumber(newPhoneNumber: phn)
        
        performSegue(withIdentifier: "emailSegue", sender: self)
        
    }

    override func viewDidLoad() {
        super.viewDidLoad()

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
