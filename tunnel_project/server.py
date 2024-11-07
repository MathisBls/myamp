import socket
import threading

# Paramètres du serveur de tunnel
TUNNEL_HOST = '0.0.0.0'  # Écouter sur toutes les interfaces
TUNNEL_PORT = 9999       # Port du serveur de tunnel

def handle_tunnel_connection(client_socket, local_server_socket):
    """ Transfère les données du client distant au serveur local via le tunnel """
    while True:
        try:
            data = client_socket.recv(4096)
            if not data:
                break
            local_server_socket.sendall(data)
        except Exception as e:
            print(f"Erreur lors de la transmission au serveur local : {e}")
            break

    client_socket.close()

def handle_local_response(local_server_socket, client_socket):
    """ Transfère les données du serveur local au client via le tunnel """
    while True:
        try:
            data = local_server_socket.recv(4096)
            if not data:
                break
            client_socket.sendall(data)
        except Exception as e:
            print(f"Erreur lors de la transmission au client distant : {e}")
            break

    local_server_socket.close()

def main():
    # Création du socket serveur pour le tunnel
    server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    server_socket.bind((TUNNEL_HOST, TUNNEL_PORT))
    server_socket.listen(5)
    print(f"Serveur de tunnel en écoute sur {TUNNEL_HOST}:{TUNNEL_PORT}")

    while True:
        # Accepter une nouvelle connexion (client distant)
        client_socket, client_address = server_socket.accept()
        print(f"Nouvelle connexion entrante de {client_address}")

        # Connexion au client local (serveur)
        local_server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        local_server_socket.connect(('127.0.0.1', 5000))  # Connecter sur localhost et un port par défaut pour l'exemple

        # Démarrage des threads pour relayer les données entre client distant et serveur local
        thread_tunnel = threading.Thread(target=handle_tunnel_connection, args=(client_socket, local_server_socket))
        thread_response = threading.Thread(target=handle_local_response, args=(local_server_socket, client_socket))

        thread_tunnel.start()
        thread_response.start()

if __name__ == '__main__':
    main()
