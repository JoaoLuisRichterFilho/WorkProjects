from cmd import PROMPT
import cryptocode
import requests

print("Cadastre seu acesso LDAP para utilizar nas automações")

API_key = input("Informe a chave de API:")
user = input("Informe o seu usuário:")
password = input("Informe sua senha:")

chave = "423338233093093"

userCrypto = cryptocode.encrypt(user, chave)
passCrypto = cryptocode.encrypt(password, chave)

pload = {'public_key':API_key, 'action':'cad', 'user':userCrypto, 'password':passCrypto}
r = requests.post('http://localhost/rpa/api.php', data = pload)

print('return status: ' + r.status_code)
print('return: ' + r.text)

# print("Usuario criptografado: " + userCrypto)
# print("Senha criptografada: " + passCrypto)

# UserDecrypt = cryptocode.decrypt(userCrypto, chave)
# PassDecrypt = cryptocode.decrypt(passCrypto, chave)
# print("Usuario descriptografado: " + UserDecrypt)
# print("Senha descriptografada: " + PassDecrypt)