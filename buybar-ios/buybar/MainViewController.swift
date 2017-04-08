//
//  MainViewController.swift
//  buybar
//
//  Created by iostest on 4/8/17.
//  Copyright © 2017 Joshua Wagner. All rights reserved.
//

import UIKit

class MainViewController: UIViewController {

    @IBOutlet weak var closeTab: UIButton!
    
    override func viewDidLoad() {
        super.viewDidLoad()

        closeTab.backgroundColor = UIColor.gray
        closeTab.setTitleColor(.white, for: .normal)
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
