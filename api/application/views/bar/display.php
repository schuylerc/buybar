

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>

<table class="table table-striped">
  <tr>
    <th style="width: 75px">ID</th>
    <th style="width: 300px">Customer</th>
    <th>Order</th>
    <th style="width: 170px">Actions</th>
  </tr>
  <?PHP foreach($orders as $order): ?>
  <tr id="order<?PHP echo $order->id; ?>">
    <td><h3><?PHP echo $order->id; ?></h3></td>
    <td><h3><?PHP echo $order->first_name." ".$order->last_name; ?></h3></td>
    <td><h3><?PHP echo $order->title; ?></h3></td>
    <td>
      <button onclick="clearItem(<?PHP echo $order->id; ?>)" class="btn btn-danger" style="height: 60px;  width: 70px;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
      <?PHP if(!$order->ready){ ?><button onclick="readyItem(<?PHP echo $order->id; ?>)" class="btn btn-success" style="height: 60px; width: 70px;"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button><?PHP } ?>
    </td>
  </tr>
  <?PHP endforeach; ?>
</table>

<?PHP if(count($orders)==0){ ?>
<h1 style="text-align: center; color: #D3D3D3; padding-top: 150px;">No Active Orders</h1>  
<?PHP } ?>

<script>
setTimeout(function(){ window.location = "/bar"; }, 5000);
function clearItem(id){
  window.location = '/bar/clear/' + id;
}
function readyItem(id){
  window.location = '/bar/ready/' + id;
}
</script>