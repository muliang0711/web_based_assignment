<?php
include __DIR__ . "/../admin/FINALDEMO.PHP";
?>

        <table class="tb">
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