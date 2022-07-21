# import sys
# for sys in sys.path:
#     print(sys)  

# exit(0)

import urllib.request #lib usada para realizar requisicoes http
from bs4 import BeautifulSoup

wiki = 'https://cotripal.com.br/'
page = urllib.request.urlopen(wiki)
soup = BeautifulSoup(page, 'html5lib')
list_item = soup.find_all('span', attrs={'class': 'valor-graos'})
if list_item:
    for el in list_item:
        name = el.text.strip()
        print(name)

exit(0)

print("Menu RPA:")
print("[1] - Consulta o valor do soja")
print("[2] - Consulta a temperatura atual em Ijuí")
print("[3] - Consulta valor do Dolar")
print("[4] - Consulta valor do Bitcoin")
input("Informe a automacao que deseja rodar:")