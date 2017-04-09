//
//  MenuViewController.swift
//  buybar
//
//  Created by iostest on 4/8/17.
//  Copyright © 2017 Joshua Wagner. All rights reserved.
//

import UIKit

class MenuViewController: UIViewController {

    @IBOutlet weak var checkInButton: UIButton!
    @IBOutlet weak var logo: UILabel!
    
    override func viewDidLoad() {
        super.viewDidLoad()

        self.view.backgroundColor = UIColor.black
        checkInButton.backgroundColor = UIColor.gray
        checkInButton.setTitleColor(UIColor.white, for: UIControlState.normal)
        
        logo.textColor = UIColor.white
        
//        logo.font = logo.font.withSize(80)

        // Do any additional setup after loading the view.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    @IBAction func pinRequest(_ sender: UIButton) {
        
        let alertController = UIAlertController(title: "Login", message: "Please enter your password:", preferredStyle: .alert)
        
        let confirmAction = UIAlertAction(title: "Confirm", style: .default) { (_) in
            if (alertController.textFields![0] as? UITextField) != nil {
                
                if(alertController.textFields![0].text == "password"){
                    print("True")
                    self.performSegue(withIdentifier: "bouncer", sender: self)
                }
                else{
                    print("False")
                }
                // store your data
//                UserDefaults.standard.set(field.text, forKey: "userPin")
//                UserDefaults.standard.synchronize()
            } else {
                // user did not fill field
            }
        }
        
        let cancelAction = UIAlertAction(title: "Cancel", style: .cancel) { (_) in }
        
        alertController.addTextField { (textField) in
            textField.placeholder = "Password"
        }
        
        alertController.addAction(confirmAction)
        alertController.addAction(cancelAction)
        
        self.present(alertController, animated: true, completion: nil)
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
