<div class="content_cover">
    <div class="view_title">
        <h3>Account</h3>
    </div>
    <div class="view_nav_bar" style="visibility: hidden;">
        <ul>
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
    <div class="items_area item_area_account_password">
        <div class="account_password_elemental">
            <div class="password_entry_card">
                <h5>User Verification</h5>
                <p>Please Enter your Password to Proceed</p>
                <input type="password" name="passwordConfirm">
            </div>
            <button onclick="open_accountForm_view('control','<?php echo $_SESSION['LOGGED_USER']?>')">Submit</button>
        </div>
    </div>
</div>