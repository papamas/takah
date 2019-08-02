            <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
				    <li>
                        <a  class="<?php if($this->uri->segment(1)==="welcome") echo "active-menu" ?>" href="<?php echo site_url()?>/welcome/"><i class="fa fa-dashboard fa-3x"></i> Dashboard</a>
                    </li>
					<li>
                        <a  class="<?php if($this->uri->segment(1)==="pascascanning" || $this->uri->segment(1)==="prascanning" || $this->uri->segment(1)==="scanning") echo "active-menu" ?>" href="#"><i class="fa fa-file fa-3x"></i> DMS <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">						    							
							<li><a  href="<?php echo site_url()?>/scanning/search">Search</a></li>		 
							
						</ul>	
					</li>
					
					               			 
                </ul>
               
            </div>
            
        </nav>  
        
