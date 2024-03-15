<div class="breadcrumb clearfix">
  <ul>
    <!-- A breadcrumb navigation menu that displays the current page and its ancestors -->
    <li><a href="index.php?app=Dashboard">Dashboard</a></li>
    <li><a href="">Ferramentas</a></li>
    <li class="active">Regras</li>  <!-- The current page is "Regras" */>
  </ul>
</div>

<div class="page-header">
  <h1>Ferramentas <small>Dicas de Regras</small></h1>
</div>

<div class="row" id="powerwidgets">
  <div class="col-md-12 bootstrap-grid"> 

    <div class="powerwidget orange" id="most-form-elements" data-widget-editbutton="false">
      <header>
        <h2>Dicas<small> Regras Para Firewall</small></h2>
      </header>
      <div class="inner-spacer">

        <!-- A list of firewall rules for a network firewall -->

        <!-- Rule 1: Block external access to the proxy and DNS -->
        <h3>Bloquear acesso externo ao proxy e ao DNS</h3>
        <div class="highlight">
          <pre><code class="language-css" data-lang="css">
/ip firewall filter
add chain=input in-interface=”wan” protocol=tcp dst-port=3128 action=drop comment=”Bloqueia Acesso Externo Proxy” disabled=no
add chain=input in-interface=”wan” protocol=tcp dst-port=53 action=drop comment=”Bloqueia Acesso Externo ao DNS” disabled=no</code></pre>
        </div>
        Note: The port number for the proxy is set to 3128 in this example. If a different port number is used, it should be updated in the rule.

        <hr>

        <!-- Rule 2: Automated script for concurrent connection rules -->
        <h3>Script automático para regras de conexão simultâneas</h3>
        <div class="highlight">
          <pre><code class="language-css" data-lang="css">
/ip firewall filter
: for i from=2 to=254 do={ add chain=forward src-address=(“192.168.0.” . $i) protocol=tcp tcp-flags=syn connection-limit=30,32 action=drop comment=”Controle de conexoes simultaneas”}</code></pre>
        </div>
        This script generates connection limit rules for each IP address from 192.168.0.2 to 192.168.0.254. The IP address range can be modified as needed.

        <hr>

        <!-- Rule 3: Block all ports -->
        <h3>Bloquear todas as portas</h3>
        <div class="highlight">
          <pre><code class="language-css" data-lang="css">
/ip firewall filter
add chain=forward protocol=tcp dst-port=0-65535 action=drop comment=”Bloqueio geral” disabled=no</code></pre>
        </div>
        This rule blocks all ports from 0 to 65535. It can be used in conjunction with other rules that allow access to specific ports.

        <hr>

        <!-- Rule 4: Block specific adware and malware domains -->
        <h3>Bloqueio ASK Toolbar, FunMods, Iminent, 22Find, Baidu, PC Reformer</h3>
        <div class="highlight">
          <pre><code class="language-css" data-lang="css">
/ip firewall filter add chain=output dst-address=180.76.2.25 action=drop comment=BAIDU
/ip firewall filter add chain=output dst-address=220.181.111.86 action=drop
/ip firewall filter add chain=output dst-address=46.28.209.15 action=drop comment=PC-PERFORMER-DRIVER-SCANNER
/ip firewall filter add chain=output dst-address=96.45.82.5 action=drop
/ip firewall filter add chain=output dst-address=208.94.116.112 action=drop comment=DEALPLY
/ip firewall filter add chain=output dst-address=66.77.197.179 action=drop comment=DELTA-TOOL-BAR
/ip firewall filter add chain=output dst-address=69.28.58.74 action=drop comment=22FIND
/ip firewall filter add chain=output dst-address=95.130.75.74 action=drop comment=IMINENT
/ip firewall filter add chain=output dst-address=50.23.103.20 action=drop comment=FUNMOODS
/ip firewall filter add chain=output dst-address=173.255.138.100 action=drop
/ip firewall filter add chain=output dst-address=174.37.174.84 action=drop
/ip firewall filter add chain=output dst-address=174.127.102.228 action=drop
/ip firewall filter add chain=output dst-address=66.235.120.127 action=drop comment=ASK-TOOL-BAR</code></pre>
        </div>
        This set of rules blocks specific adware and malware domains.

        <hr>

      </div>
    </div>
  </div>
</div>
