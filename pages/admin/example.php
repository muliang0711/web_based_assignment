<?php
include __DIR__ . "/../admin/main.php";
?>

<?php 
// if we want our table all look same than you may copy the code below ;
// if you want to have a personal table than igoner it and develop by yourself buty just make sure all action is place on the right side 

// ------------- noted!! will you include main.php please use __DIR__ to 

// 1. after you include the main.php 
  // 1.1 : main.php auto include topbar and sidebar already 
  // 1.2 : you can based on your requirenment include sidebar or topbar independent 
  
// 2. the main content div is to make sure you div can start on the safety place ; not cover by sidebar and topbar ; 
    // so is more  better that you can just copy these copy inside you page than start : 
    // <div class="main-content"</div>

// 3. make a same search bar : 
    // 3.1 if you want a same search bar like this pages copy the code below
    /* <div style="margin-bottom: 1rem;">
      <form style="display: flex; gap: 1rem;">
        <div style="flex: 1;">
          <input type="text" placeholder="Search..." style="width: 50%; padding: 0.5rem;">
        </div>
          <!--filter bar or what right here -->
  
        <select style="padding: 0.5rem;">
          <option>All Categories</option>
          <option>Active</option>
          <option>Pending</option>
          <option>Archived</option>
        </select>

        <select style="padding: 0.5rem;">
          <option>All Categories</option>
          <option>Active</option>
          <option>Pending</option>
          <option>Archived</option>
        </select>

        <select style="padding: 0.5rem;">
          <option>All Categories</option>
          <option>Active</option>
          <option>Pending</option>
          <option>Archived</option>
        </select>
        
        <select style="padding: 0.5rem;">
          <option>All Categories</option>
          <option>Active</option>
          <option>Pending</option>
          <option>Archived</option>
        </select>
        <input type="date" style="padding: 0.5rem;">
        <button type="reset" style="padding: 0.5rem;">
          <i class="fas fa-undo"></i> Reset
        </button>
      </form>
    </div>*/

// 4. make a same table : 
    // for table part you can just add tb , th ,  tr , td , class name into your table than you will have a same table 

// 5. if you want a title than you may copy these code : 
  /*     <div class="tb-title">
      <h5 style="margin: 0;"><i class="fas fa-table"></i> title name you want </h5>
        </div>
  */


// below is a sample look 
?>
<div class="main-content">
    <!-- Example Search/Filter Section -->
    <div style="margin-bottom: 1rem;">
      <form style="display: flex; gap: 1rem;">
        <div style="flex: 1;">
          <input type="text" placeholder="Search..." style="width: 50%; padding: 0.5rem;">
        </div>
          <!--filter bar or what right here -->
  
        <select style="padding: 0.5rem;">
          <option>All Categories</option>
          <option>Active</option>
          <option>Pending</option>
          <option>Archived</option>
        </select>

        <select style="padding: 0.5rem;">
          <option>All Categories</option>
          <option>Active</option>
          <option>Pending</option>
          <option>Archived</option>
        </select>

        <select style="padding: 0.5rem;">
          <option>All Categories</option>
          <option>Active</option>
          <option>Pending</option>
          <option>Archived</option>
        </select>
        
        <select style="padding: 0.5rem;">
          <option>All Categories</option>
          <option>Active</option>
          <option>Pending</option>
          <option>Archived</option>
        </select>
        <input type="date" style="padding: 0.5rem;">
        <button type="reset" style="padding: 0.5rem;">
          <i class="fas fa-undo"></i> Reset
        </button>
      </form>
    </div>


    <!-- Example Data Table ： example usecase can see example.php-->
    
    <table class="tb">
      <div class="tb-title">
        <h5 style="margin: 0;"><i class="fas fa-table"></i> title name you want </h5>
      </div>
          <thead>
            <tr style="background-color: #f9f9f9;">
              <th class="th">Order ID</th>
              <th class="th">Customer</th>
              <th class="th">Status</th>
              <th class="th">Total</th>
              <th class="th">Status</th>
              <th class="th">Total</th>
              <th class="th">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="td">#1234</td>
              <td class="td">John Doe</td>
              <td class="td">#1234</td>
              <td class="td">John Doe</td>
              <td class="td">
                <span class="status-span">Completed</span>
              </td>
              <td class="td">199.99</td>
              <td class="td">
                <button class="action-btn-add">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="action-btn-delete">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
           
            <!-- Additional rows as needed -->
          </tbody>
        </table>
</div>