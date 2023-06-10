
<div class="side-content-wrap">
	<div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
		<ul class="navigation-left">
			<li class="nav-item" data-item="dashboard">
				<a class="nav-item-hold" href="#">
					<i class="nav-icon i-Bar-Chart"></i>
					<span class="nav-text">Tableau de bord</span>
				</a>
				<div class="triangle"></div>
			</li>
			<li class="nav-item" data-item="extrakits">
				<a class="nav-item-hold" href="#">
					<i class="nav-icon i-Gears"></i>
					<span class="nav-text">Parametrages</span>
				</a>
				<div class="triangle"></div>
			</li>
			<li class="nav-item" data-item="gentree">
				<a class="nav-item-hold" href="#">
					<i class="nav-icon i-Cash-register-2"></i>
					<span class="nav-text">Gestion Entrée</span>
				</a>
				<div class="triangle"></div>
			</li>
			<li class="nav-item" data-item="gclient">
				<a class="nav-item-hold" href="#">
					<i class="nav-icon i-Business-ManWoman"></i>
					<span class="nav-text">Gestion Clients</span>
				</a>
				<div class="triangle"></div>
			</li>
			<li class="nav-item" data-item="gsortie">
				<a class="nav-item-hold" href="#">
					<i class="nav-icon i-Remove-Cart"></i>
					<span class="nav-text">Gestion Sortie</span>
				</a>
				<div class="triangle"></div>
			</li>
			<li class="nav-item" data-item="gdepense">
				<a class="nav-item-hold" href="#">
					<i class="nav-icon i-Financial"></i>
					<span class="nav-text">Gestion depense</span>
				</a>
				<div class="triangle"></div>
			</li>

			<li class="nav-item" data-item="sessions">
				<a class="nav-item-hold" href="#">
					<i class="nav-icon i-Administrator"></i>
					<span class="nav-text">{{ __('Accée et securité')}}</span>
				</a>
				<div class="triangle"></div>
			</li>

			<li class="nav-item">
				<a class="nav-item-hold" href="" target="_blank">
					<i class="nav-icon i-Safe-Box1"></i>
					<span class="nav-text">Doc</span>
				</a>
				<div class="triangle"></div>
			</li>
		</ul>
	</div>

	<div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
		<!-- Submenu Dashboards -->
		<ul class="childNav" data-parent="dashboard">
			<li class="nav-item">
				<a href="{{ route('home') }}">
					<i class="nav-icon i-Clock-3"></i>
					<span class="item-name">{{ __('Tableau de bord')}}</span>
				</a>
			</li>
		</ul>
		<ul class="childNav" data-parent="forms">
			<li class="nav-item">
				<a href="form.basic.html">
					<i class="nav-icon i-File-Clipboard-Text--Image"></i>
					<span class="item-name">Basic Elements</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="form.layouts.html">
					<i class="nav-icon i-Split-Vertical"></i>
					<span class="item-name">Form Layouts</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="form.input.group.html">
					<i class="nav-icon i-Receipt-4"></i>
					<span class="item-name">Input Groups</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="form.validation.html">
					<i class="nav-icon i-Close-Window"></i>
					<span class="item-name">Form Validation</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="smart.wizard.html">
					<i class="nav-icon i-Width-Window"></i>
					<span class="item-name">Smart Wizard</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="tag.input.html">
					<i class="nav-icon i-Tag-2"></i>
					<span class="item-name">Tag Input</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="editor.html">
					<i class="nav-icon i-Pen-2"></i>
					<span class="item-name">Rich Editor</span>
				</a>
			</li>
		</ul>
		<ul class="childNav" data-parent="apps">
			<li class="nav-item">
				<a href="invoice.html">
					<i class="nav-icon i-Add-File"></i>
					<span class="item-name">Invoice</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="inbox.html">
					<i class="nav-icon i-Email"></i>
					<span class="item-name">Inbox</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="chat.html">
					<i class="nav-icon i-Speach-Bubble-3"></i>
					<span class="item-name">Chat</span>
				</a>
			</li>
		</ul>

		<ul class="childNav" data-parent="widgets">
			<li class="nav-item">
				<a class="" href="widget-card.html">
					<i class="nav-icon i-Receipt-4"></i>
					<span class="item-name">widget card</span>
				</a>
			</li>
			<li class="nav-item">


				<a class=""
					href="widgets-statistics.html">
					<i class="nav-icon i-Receipt-4"></i>
					<span class="item-name">widget statistics</span>
				</a>
			</li>

			<li class="nav-item">


				<a class="" href="widget-list.html">
					<i class="nav-icon i-Receipt-4"></i>
					<span class="item-name">Widget List <span class="ml-2 badge badge-pill badge-danger">
							New</span></span>
				</a>
			</li>

			<li class="nav-item">


				<a class="" href="widget-app.html">
					<i class="nav-icon i-Receipt-4"></i>
					<span class="item-name">Widget App <span class="ml-2 badge badge-pill badge-danger"> New</span>
					</span>
				</a>
			</li>
			<li class="nav-item">


				<a class=""
					href="weather-card.html">
					<i class="nav-icon i-Receipt-4"></i>
					<span class="item-name"> Weather App <span class="ml-2 badge badge-pill badge-danger"> New</span>
					</span>
				</a>
			</li>

		</ul>


		<!-- chartjs -->
		<ul class="childNav" data-parent="charts">
			<li class="nav-item">
				<a class="" href="charts.echarts.html">
					<i class="nav-icon i-File-Clipboard-Text--Image"></i>
					<span class="item-name">echarts</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="" href="charts.chartsjs.html">
					<i class="nav-icon i-File-Clipboard-Text--Image"></i>
					<span class="item-name">ChartJs</span>
				</a>
			</li>
			<li class="nav-item dropdown-sidemenu">
				<a class="" href="">
					<i class="nav-icon i-File-Clipboard-Text--Image"></i>
					<span class="item-name">Apex Charts</span>
					<i class="dd-arrow i-Arrow-Down"></i>
				</a>
				<ul class="submenu">
					<li><a class=""
							href="charts.apexAreaCharts.html">Area Charts</a></li>
					<li><a class=""
							href="charts.apexBarCharts.html">Bar Charts</a></li>
					<li><a class=""
							href="charts.apexBubbleCharts.html">Bubble Charts</a></li>
					<li><a class=""
							href="charts.apexColumnCharts.html">Column Charts</a></li>
					<li><a class=""
							href="charts.apexCandleStickCharts.html">CandleStick Charts</a></li>
					<li><a class=""
							href="charts.apexLineCharts.html">Line Charts</a></li>
					<li><a class=""
							href="charts.apexMixCharts.html">Mix Charts</a></li>
					<li><a class=""
							href="charts.apexPieDonutCharts.html">PieDonut Charts</a></li>
					<li><a class=""
							href="charts.apexRadarCharts.html">Radar Charts</a></li>
					<li><a class=""
							href="charts.apexRadialBarCharts.html">RadialBar Charts</a></li>
					<li><a class=""
							href="charts.apexScatterCharts.html">Scatter Charts</a></li>
					<li><a class=""
							href="charts.apexSparklineCharts.html">Sparkline Charts</a></li>

				</ul>
			</li>





		</ul>


		{{-- sous menu parametrages --}}
		<ul class="childNav" data-parent="extrakits">
			<li class="nav-item">
				<a href="{{ route('parametrages.site')}}">
					<i class="nav-icon i-Globe"></i>
					<span class="item-name">{{ __('Gestion site')}}</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('parametrages.batiments')}}">
					<i class="nav-icon i-Home1"></i>
					<span class="item-name">{{ __('Batiment')}}</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('parametrages.categorie_depenses')}}">
					<i class="nav-icon i-Tag-3"></i>
					<span class="item-name">{{ __('Catégorie depense')}}</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('parametrages.type_depenses')}}">
					<i class="nav-icon i-Dollar-Sign"></i>
					<span class="item-name">{{ __('Type dépense')}}</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('parametrages.type_poulets')}}">
					<i class="nav-icon i-File-Download"></i>
					<span class="item-name">{{ __('Type poulet')}}</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('parametrages.type_oeufs') }}">
					<i class="nav-icon i-File-Cloud"></i>
					<span class="item-name">{{ __('Type oeuf')}}</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('parametrages.type_sorties')}}">
					<i class="nav-icon i-Remove-Basket"></i>
					<span class="item-name">{{ __('Type sortie')}}</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('parametrages.libelle_depense')}}">
					<i class="nav-icon i-Financial"></i>
					<span class="item-name">{{ __('Libelle depense')}}</span>
				</a>
			</li>
		</ul>
		{{-- Fin sous menu parametrages --}}
		<ul class="childNav" data-parent="gentree">
			<li class="nav-item">
				<a href="{{ route('gestion_entree.cycles')}}">
					<i class="nav-icon i-Shopping-Basket"></i>
					<span class="item-name">Gestion Cycle</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('gestion_entree.constat_oeufs')}}">
					<i class="nav-icon i-File-Copy"></i>
					<span class="item-name">{{ __('Constat oeuf')}}</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('gestion_entree.constat_poulets')}}">
					<i class="nav-icon i-File-Copy"></i>
					<span class="item-name">{{ __('Constat poulet')}}</span>
				</a>
			</li>
		</ul>
		{{-- debut gestion sortie --}}
		<ul class="childNav" data-parent="gsortie">
			<li class="nav-item">
				<a href="{{ route('gestion_sortie.prix_poulets')}}">
					<i class="nav-icon i-Money1"></i>
					<span class="item-name">Prix poulet</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('gestion_sortie.sortie_poulets')}}">
					<i class="nav-icon i-Remove-Basket"></i>
					<span class="item-name">Sortie poulet</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('gestion_sortie.prix_oeufs')}}">
					<i class="nav-icon i-Money1"></i>
					<span class="item-name">Prix oeuf</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('gestion_sortie.sortie_oeufs')}}">
					<i class="nav-icon i-Remove-Basket"></i>
					<span class="item-name">Sortie oeuf</span>
				</a>
			</li>
		</ul>
		{{-- fin gestion sortie--}}
		{{-- debut gestion client --}}
		<ul class="childNav" data-parent="gclient">
			<li class="nav-item">
				<a href="{{ route('gestion.clients')}}">
					<i class="nav-icon i-Business-ManWoman"></i>
					<span class="item-name">Gestion client</span>
				</a>
			</li>
		</ul>
		{{-- fin gestion client--}}
		{{-- debut gestion depense --}}
		<ul class="childNav" data-parent="gdepense">
			<li class="nav-item">
				<a href="{{ route('gestion_depense.unites')}}">
					<i class="nav-icon i-Money-2"></i>
					<span class="item-name">Unité depense</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('gestion_depense.liste_depenses')}}">
					<i class="nav-icon i-Money-Bag"></i>
					<span class="item-name">Liste dépense</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('gestion_depense.engagement_charges') }}">
					<i class="nav-icon i-Wallet"></i>
					<span class="item-name">Engagement charge</span>
				</a>
			</li>
		</ul>
		{{-- fin gestion depense--}}
		<ul class="childNav" data-parent="sessions">
			<li class="nav-item">
				<a href="#">
					<i class="nav-icon i-Key"></i>
					<span class="item-name">Gestion permissions</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="#">
					<i class="nav-icon i-Add-User"></i>
					<span class="item-name">Gestion roles</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="#">
					<i class="nav-icon i-Business-Mens"></i>
					<span class="item-name">Gestion utilisateurs</span>
				</a>
			</li>
		</ul>
		<ul class="childNav" data-parent="others">
			<li class="nav-item">
				<a href="not.found.html">
					<i class="nav-icon i-Error-404-Window"></i>
					<span class="item-name">Not Found</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="user.profile.html">
					<i class="nav-icon i-Male"></i>
					<span class="item-name">User Profile</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="blank.html" class="open">
					<i class="nav-icon i-File-Horizontal"></i>
					<span class="item-name">Blank Page</span>
				</a>
			</li>
		</ul>
	</div>
	<div class="sidebar-overlay"></div>
</div>