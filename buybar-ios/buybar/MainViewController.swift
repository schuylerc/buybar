//
//  MainViewController.swift
//  buybar
//
//  Created by iostest on 4/8/17.
//  Copyright © 2017 Joshua Wagner. All rights reserved.
//

import UIKit

class MainViewController: UIViewController, UITableViewDataSource, UITableViewDelegate {
    
    @IBOutlet weak var tableView: UITableView!
    @IBOutlet weak var closeTab: UIButton!
    
    var menuItemArray = ["one", "two", "three"]
    
    override func viewDidLoad() {
        super.viewDidLoad()

        closeTab.backgroundColor = UIColor.gray
        closeTab.setTitleColor(.white, for: .normal)
        
        print(SessionId.getId())
        print(SessionId.getEmail())
        print(SessionId.getPhoneNumber())
        
        self.tableView.delegate = self
        self.tableView.dataSource = self
        
        self.view.backgroundColor = UIColor.black

        // Do any additional setup after loading the view.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return menuItemArray.count
    }
    
    func numberOfSectionsInTableView(tableView: UITableView) -> Int {
        return 1;
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: "customcell", for: indexPath)
        cell.textLabel?.text = menuItemArray[indexPath.item]
        return cell
    }
    
    func tableView(_ tableView: UITableView, didSelectRowAt indexPath: IndexPath) {
        
        tableView.deselectRow(at: indexPath as IndexPath, animated: true)
        
        let row = indexPath.row
        print("Row: \(row)")
        
        let alert = UIAlertController(title: "Alert", message: "Purchase " + menuItemArray[indexPath.row] + "?", preferredStyle: UIAlertControllerStyle.alert)
        let okAction = UIAlertAction(title: "Yes", style: UIAlertActionStyle.cancel) {
            UIAlertAction in
            NSLog("Yes Pressed")
        }
        let cancelAction = UIAlertAction(title: "Cancel", style: UIAlertActionStyle.default) {
            UIAlertAction in
            NSLog("Cancel Pressed")
        }

        alert.addAction(cancelAction)
        alert.addAction(okAction)
        
        self.present(alert, animated: true, completion: nil)
    }
    
    
    @IBAction func close(_ sender: Any) {
        print("button pressed")
        let alert = UIAlertController(title: "Alert", message: "Are you sure you want to check out?", preferredStyle: UIAlertControllerStyle.alert)
        let okAction = UIAlertAction(title: "Yes", style: UIAlertActionStyle.cancel) {
            UIAlertAction in
            NSLog("Yes Pressed")
            self.performSegue(withIdentifier: "backToBeg", sender: self)
        }
        let cancelAction = UIAlertAction(title: "Cancel", style: UIAlertActionStyle.default) {
            UIAlertAction in
            NSLog("Cancel Pressed")
        }
        
        alert.addAction(cancelAction)
        alert.addAction(okAction)
        
        self.present(alert, animated: true, completion: nil)
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
