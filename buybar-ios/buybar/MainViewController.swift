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
        BarBrain.getMenuItems()
        closeTab.backgroundColor = UIColor.gray
        closeTab.setTitleColor(.white, for: .normal)
        
        print(SessionId.getId())
        print(SessionId.getEmail())
        print(SessionId.getPhoneNumber())
        
        self.tableView.delegate = self
        self.tableView.dataSource = self

        // Do any additional setup after loading the view.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return BarBrain.menuItemsArray.count
    }
    
    func numberOfSectionsInTableView(tableView: UITableView) -> Int {
        return 1;
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: "customcell", for: indexPath)
        cell.textLabel?.text = BarBrain.menuItemsArray[indexPath.item].title
        return cell
    }
    
    func tableView(_ tableView: UITableView, didSelectRowAt indexPath: IndexPath) {
        
        tableView.deselectRow(at: indexPath as IndexPath, animated: true)
        
        let row = indexPath.row
        print("Row: \(row)")
        
//        print(meetingArray[row] as! String)
        
    }
    
    
    @IBAction func close(_ sender: Any) {
        print("button pressed")
//        BarBrain.getMenuItems()
        print(BarBrain.menuItemsArray)
        self.tableView.reloadData()
        print("done with get menu*****************")
//        print(x[0].title)
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
