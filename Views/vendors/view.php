<div class="content_cover">
                <div class="view_title">
                    <h3>Vendors</h3>
                </div>
                <div class="view_nav_bar">
                    <ul>
                        <li>
                            <button>New Vendor</button>
                        </li>
                        <li>
                            <button>Delete</button>
                        </li>
                        <li>
                            <button>Update</button>
                        </li>
                        <li>
                        <select name="" id="">
                                <option value="QuickReports">Quick Reports</option>
                                <option value="List">List</option>
                            </select>
                        </li>
                        <li>
                            <select name="" id="">
                                <option value="QuickReports">Quick Reports</option>
                                <option value="List">List</option>
                            </select>
                        </li>
                    </ul>
                    <div class="element_search">
                        <input type="Search">
                    </div>
                </div>
                <div class="items_area">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col"> <div class="check_element"><input type="checkbox"></div> </th>
                                <th scope="col">#</th>
                                <th scope="col">Vendor ID</th>
                                <th scope="col">Vendor Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Status</th>
                                <th scope="col">Balance</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            for($i = 0; $i < 30; $i++){
                                ?>
                            <tr>
                                <td><div class="check_element"><input type="checkbox"></div></td>
                                <td><?php echo ($i + 1)?></td>
                                <td>VE-0001</td>
                                <td>Mizinga Limited</td>
                                <td>info@mizinga.com</td>
                                <td>+254 700 000 000</td>
                                <td>Active</td>
                                <td>0.00</td>
                                
                            </tr>
                            <?php
                            }?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    <ul>
                        <li id="previous_pagination"> <p>Prev</p> </li>
                        <li> <p>1</p> </li>
                        <li> <p>2</p> </li>
                        <li class="next_pagination"> <p>Next</p> </li>
                    </ul>
                </div>
            </div>