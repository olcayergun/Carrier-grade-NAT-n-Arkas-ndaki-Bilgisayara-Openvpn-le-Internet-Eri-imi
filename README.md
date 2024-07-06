Carrier-grade NAT ile internette bağlı bir ağın içindeki bir bilgisayara ulaşmak için şunları yapabiliriz:
Gerekli olanlar:
1. VPS'de veya geröek IP adresi olan bir linux kutusu (oracle veya diğer cloud hizmeti veren yerler.)
2. NAT'in arkasındaki ağa bulunan bir linux kutusu (eski bilgisayar, Pİ veya virtual makine olablilir.)

VPS'deki, linux kutusu server, diğer li,nuz kutusu ise client olarak anılacaktır.

Adımlar:
1. server'daki sisteme openvpn, herhangi bir http proxy ve web server ve php gibi kurulumlar yapılır.
2. Özel ip adreslerin internette erişim için gerekli NAT ayarları:
  iptables --table nat --append POSTROUTING --out-interface eth0 -j MASQUERADE
  iptables --append FORWARD --in-interface eth0 --out-interface tun0 -m state --state RELATED,ESTABLISHED -j ACCEPT
  iptables --append FORWARD --in-interface tun0 --out-interface eth0 -j ACCEPT
3. Şifrele için için server ve client için gerekli sertifika dosyaları oluşturulur.
    Server için: ca.crt, xx.crt, xx.key, dh.pem
    Client için: ca.crt, xxxxx.crt, xxxx.key, dh.pem
4. Server'da '/etc/opencpn/server' dizinin altına 'ccd' adında bir dizin açılır ve xxxx dosyası bu dizine kopyalanır.
5. server.conf dosyası '/etc/opencpn/server' dizinin altına kopyalanır.
6. IP yönlendirmeyi hem server'da hem de lient'ta aktif etmek için:
  echo 1 > /proc/sys/net/ipv4/ip_forward
7. client.conf dosyası client'ın altındaki '/etc/opencpn/client' dizinine kopyalanır.
8. server kutusunda openvpn başlangıçta başlatmak için
  systemctl restart openvpn-server@server.service
  systemctl enable openvpn-server@server.service
10. client kutusunda openvpn başlangıçta başlatmak için
  systemctl restart openvpn-client@client.service
  systemctl enable openvpn-client@client.service
11. client ile aynı ağda bulunan ve erişmek istediğimiz bir makinenin default gateway tanımını client'ın ip adresi yapmalıyız.

Bu noktada serverdan erişmek istediğimiz ve default gateway adresini client'ın ip adresi yaptığımız makineye ulaşabiliriz.
