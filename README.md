<h1>Information</h1>
<ol>
<li><strong>Core Parts mostly extendable and editable:</strong></li>
  <ul>
    <li>Controllers - Currently works as the main class of the application</li>
    <li>Parsers</li>
    <li>Output</li>
    <li>Converters - allows creating specific currency converter with different rates</li>
    <li>Taxes - Handle the taxes logic for each different user type and amount + can be added other classes with different implementation logic, without restriction from the library</li>
    <li>Helper functions</li>
    <li>Input wrapper around the parser class</li>
  </ul>
<li><strong>Execution Logic</strong></li>
run via terminal/console

> php -f index.php example.csv 
</ol>
