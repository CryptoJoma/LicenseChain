<?php

 if($role === "5"){ // User Elite ?>
  <li><a href="/" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔧 Licenses</a></li>
  <li><a href="/bill" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔑 Wallet</a></li>
  <li><a href="/minutes" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">⏱️ Minutes</a></li>
  <li><a href="/routes" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔧 Routes</a></li>
  <li><a href="https://t.me/LicenseChain" target="_blank" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🤝 Support</a></li>
<? } elseif($role === "6"){ // Seller Elite ?>

    <li><a href="/" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔧 Customers</a></li>
    <li><a href="/routes" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔧 Routes</a></li>
    <li><a href="/settings" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔧 Settings</a></li>
<? } elseif($role === "69"){ // Master ?>

  <li><a href="/" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔧 Customers</a></li>
  <li><a href="/sellers" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔧 Sellers</a></li>
  <li><a href="/roles" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔧 Roles</a></li>
  <li><a href="/routes" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔧 Routes</a></li>
  <li><a href="/finances" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔧 Finances</a></li>
<? } elseif($role === "3"){ // Support ?>

  <li><a href="/" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔧 Customers</a></li>
  <li><a href="/routes" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔧 Routes</a></li>
  <li><a href="https://t.me/LicenseChain" target="_blank" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🤝 Tickets</a></li>
<? } elseif($role === "2"){ // Seller ?>

  <li><a href="/" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔧 Customers</a></li>
  <li><a href="/licenses" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔑 Licenses</a></li>
  <li><a href="/finances" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔧 Finances</a></li>
  <li><a href="/settings" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔧 Settings</a></li>
<? } else { // User ?>

  <li><a href="/" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔧 Dashboard</a></li>
  <li><a href="/licenses" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔑 Licenses</a></li>
  <li><a href="/bill" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">⏱️ Bill</a></li>
  <li><a href="https://t.me/LicenseChain" target="_blank" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🤝 Support</a></li>
<? } ?>
