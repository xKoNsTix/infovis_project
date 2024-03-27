(()=>{document.addEventListener("DOMContentLoaded",function(){var a=new JustGage({id:"energy-current-gauge",value:0,min:0,max:400,title:"Aktueller Stromverbrauch",label:"Watts/Hour",valueFontColor:"White"});function r(){fetch("fetch_sensors.php").then(e=>e.json()).then(e=>{console.log("Received data:",e);var t=parseFloat(e.energy_current);isNaN(t)?console.error("Invalid energy current value:",e.energy_current):a.refresh(t),document.getElementById("energy-total").innerHTML=function(){var u=document.getElementById("energy-total");if(u){var n=parseFloat(e.energy_total.replace(",","."));if(isNaN(n))return console.error("Energy total value is not a valid number."),"Total Consumption Today: Invalid data";n*=1e3;var i=(n/1e3).toFixed(2).replace(".",","),s=(n*.3/1e3).toFixed(2).replace(".",",");return"Total Consumption Today: "+i+' KW<br> = <span class="euro-cent-value" style="color: #00ff00; font-size:24px;">('+s+" \u20AC)</span>"}else return console.error("Element with id 'energy-total' not found."),""}();var o=document.getElementById("energy-current");if(o){var l=(t*.3/1e3).toFixed(2);o.innerHTML="Current Consumption Office: "+t+' Watts/Hour = <span class="euro-cent-value" style="color: #00ff00; font-size:24px;">('+l+" \u20AC/h)</span>"}else console.error("Element with id 'energy-current' not found.");document.getElementById("temperature-value").innerHTML="Temperature Outside: "+e.temperature_15+" \xB0C",document.getElementById("light-intensity-value").innerHTML="Light intensity outside: "+e.light_2+" lx <br>"}).catch(e=>console.error("Error fetching sensor data:",e))}setInterval(r,1e3),r()});})();
