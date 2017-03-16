<style>
table{
    font-family: arial;
    font-size: 10px;
	margin-top:30px;;
}
</style><div style="margin-top:50px">
<table border=0 style="margin-top:30px;">
<thead>
<tr><td colspan="6"></td></tr>
<tr><td colspan="6"></td></tr>
			<tr>
			 <td style="text-align:left;vertical-align:top;width: 30px;">NO</td>
			 <td style="text-align:left;width: 125px;">NAMA</td>
			 <td style="text-align:center;width: 125px;">TMT</td>
             <td style="text-align:left;width: 150px;">INSTANSI</td>
			 <td style="text-align:left;width: 100px;">ACTION</td>
			 <td style="text-align:center;width: 150px;">JUMLAH</td>
			</tr>
			<tr><td colspan="6"></td></tr>
</thead>
<tbody>
		    <?php foreach($report as $value):?>
		     <tr>
			   <td style="width: 30px;vertical-align:top;"><?php echo $no ?></td>
			   <td style="text-align:left;width: 125px;vertical-align:top;"><?php echo $value->nama ?></td>	 
               <td style="text-align:center;width: 125px;vertical-align:top;"><?php echo $value->tmt ?></td>	 
               <td style="width: 150px;vertical-align:top;"><?php echo $value->nama_instansi ?></td>
			   <td style="width: 100px;vertical-align:top;"><?php echo $value->nama_action ?></td>
			   
			   <td style="text-align:center;width: 150px;vertical-align:top;"><?php echo $value->jumlah_npkp ?></td>
			 </tr>
			<?php $no++;endforeach;?>		
		    
</tbody></table></div>
</body>
</html>