<?php if (isset($_GET['user-id'])): ?>

	
	<div class="card">

		<div class="row">
			<a class="btn-small waves-effect waves-light red lighten-2 white-text" href="<?php echo admin_url('edit.php?post_type=messages-list&page=conversation-list'); ?>"><- Back</a>
		</div>

		<?php 
		$user_id = $_GET['user-id'];
	    $udata = get_user_by( 'id', $user_id );
		$role =  $udata->roles[0]; 
		$name = $udata->first_name.' '.$udata->last_name;
		?>

		<h4>Messages of <?php echo $name; ?></h4>
		
		    		        	
		<table class="messages-table table table-striped table-bordered striped" cellspacing="0" width="100%">

			<thead>
			    <tr>
				    <th>Name</th>  
				    <th>Email Address</th>
				    <th class="action"></th>
			    </tr>
			</thead>

	    	<?php 
	    	$meta = array();
			if($role == 'customer'){
				$meta = array(
					'key' => 'customer_id',
					'value' => $udata->id,
					'compare' => '=',
				);
			}elseif($role == 'supplier'){
				$meta = array(
					'key' => 'supplier_id',
					'value' => $udata->id,
					'compare' => '=',
				);
			}

			$posts = get_posts( array(
				'post_type' => 'messages-list',
				'meta_query' => array( $meta )
			) );

			if ($posts) {							

				foreach ($posts as $post) {
					$post_id = $post->ID;

					$supplier_id = get_field('supplier_id', $post_id);
					$customer_id = get_field('customer_id', $post_id);

					if($role == 'customer'){
						$id = $supplier_id;
					}elseif($role == 'supplier'){
						$id = $customer_id;
					}

		        	$udata = get_user_by( 'id', $id );

		        	echo '<tr>';
						echo '<td>'.$udata->first_name.' '.$udata->first_name.'</td>';
						echo '<td>'.$udata->user_email.'</td>';
						echo '<td class="right-align"><a data-customer="'.$customer_id.'" data-supplier="'.$supplier_id.'" class="btn-small waves-effect waves-lightx grey lighten-2 white-texxt modal-trigger" href="#modal">View Conversations</a></td>';
		        	echo '</tr>';

				}
			}

			else{
				echo '<tr><td colspan="2" class="center-align">No messages found</td></tr>';
			}

	    	?>
		</table>

		<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
		<input type="hidden" name="nonce" value="<?php echo wp_create_nonce( "messages-list" ); ?>">

		<!-- Modal Structure -->
		<div id="modal" class="modal modal-fixed-footer">
		    <div class="modal-content">


		      	<div class="centered preloader">
			      	<div class="preloader-wrapper big active">
					    <div class="spinner-layer spinner-blue-only">
				      		<div class="circle-clipper left">
				        		<div class="circle"></div>
					      	</div>
					      	<div class="gap-patch">
					        	<div class="circle"></div>
					      	</div>
					      	<div class="circle-clipper right">
						        <div class="circle"></div>
					      	</div>
					    </div>
					</div>
					<label>Loading conversations...</label>
		      	</div>

		      	<ul class="conversation-list"></ul>

		    </div>
		    <div class="modal-footer">
		      	<a href="#!" class="btn-small waves-effect waves-light red lighten-2 white-text modal-close">Close</a>
		    </div>
		</div>

	</div>


<?php else: ?>

	<div class="card">

		<div class="row">
			<div class="input-field col s12 m3">
				<select class="custom-search">
					<option value="">Select Role</option>
					<option value="Customer">Customer</option>
					<option value="Supplier">Supplier</option>
				</select>
			</div>
		</div>
		
		<table class="messages-table table table-striped table-bordered striped" cellspacing="0" width="100%">

			<thead>
			    <tr>
				    <th>Name</th>  
				    <th>Email Address</th>
				    <th>Role</th>
				    <th class="action"></th>
			    </tr>
			</thead>
			
			<?php 

			$customers = get_users(	array(
				'role__in' => array( 'customer', 'supplier' )
			) );
			if ($customers) {
				foreach ($customers as $customer) {
					echo '<tr>';
						echo '<td>'.$customer->first_name.' '.$customer->last_name.'</td>';
						echo '<td>'.$customer->user_email.'</td>';
						echo '<td>'.ucwords($customer->roles[0]).'</td>';
						echo '<td class="right-align"><a href="'.add_query_arg('user-id',$customer->id).'" class="btn-small waves-effect waves-light blue white-text">View messages</a></td>';
					echo '</tr>';
				}
			}
			?>

		</table>
	
	</div>

<?php endif; ?>
	
