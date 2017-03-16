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
			 <td style="text-align:center;width: 75px;">TGL</td>
			 <td style="text-align:center;vertical-align:top;width: 125px;">NIP</td>
             <td style="text-align:center;width: 75px;">TMT</td>
             <td style="text-align:left;width: 75px;">ACTION</td>
			 <td style="text-align:left;width: 150px;">INSTANSI</td>
			 <td style="text-align:left;width: 150px;">KETERANGAN</td>
			</tr>
			<tr><td colspan="6"></td></tr>
</thead>
<tbody>
		    <?php foreach($report as $value):?>
		     <tr>
			   <td style="width: 30px;vertical-align:top;"><?php echo $no ?></td>
			   <td style="text-align:center;width: 75px;vertical-align:top;"><?php echo $value->tanggal_input ?></td>
               <td style="text-align:center;width: 125px;vertical-align:top;"><?php echo $value->nip ?></td>			   
               <td style="text-align:center;width: 75px;vertical-align:top;"><?php echo $value->tmt ?></td>	 
               <td style="width: 75px;vertical-align:top;"><?php echo $value->nama_action ?></td>
			   <td style="width: 150px;vertical-align:top;"><?php echo $value->nama_instansi ?></td>
			   <td style="width: 150px;vertical-align:top;"><?php echo $value->keterangan ?></td>
			 </tr>
			<?php $no++;endforeach;?>		
		    
</tbody></table></div>
</body>
</html>