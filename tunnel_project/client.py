import socket
import threading
import sys

TUNNEL_SERVER = 'tunnel_server_ip'
TUNNEL_PORT = 9999

def handle_local_request(local_socket, tunnel_socket):
    while True:
        try:
            data = local_socket.recv(4096)
            if not data:
                break
            tunnel_socket.sendall(data)
        except Exception as e:
            print(f"Erreur lors de l'envoi des données locales : {e}")
            break

    local_socket.close()

def handle_tunnel_response(tunnel_socket, local_socket):
    """ Relaye les réponses du tunnel vers le serveur local """
    while True:
        try:
            data = tunnel_socket.recv(4096)
            if not data:
                break
            local_socket.sendall(data)
        except Exception as e:
            print(f"Erreur lors de la réception des données du tunnel : {e}")
            break

    tunnel_socket.close()

def main():
    # Vérifier que l'utilisateur a bien fourni le port
    if len(sys.argv) != 2:
        print("Usage : python client.py <port_local>")
        sys.exit(1)

    # Récupérer le port local fourni par l'utilisateur
    LOCAL_PORT = int(sys.argv[1])
    LOCAL_HOST = '127.0.0.1'

    # Connexion au serveur de tunnel distant
    try:
        tunnel_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        tunnel_socket.connect((TUNNEL_SERVER, TUNNEL_PORT))
        print(f"Connecté au serveur de tunnel {TUNNEL_SERVER}:{TUNNEL_PORT}")
    except Exception as e:
        print(f"Erreur lors de la connexion au serveur de tunnel : {e}")
        sys.exit(1)

    # Connexion à l'application locale
    try:
        local_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        local_socket.connect((LOCAL_HOST, LOCAL_PORT))
        print(f"Connecté à l'application locale sur le port {LOCAL_PORT}")
    except Exception as e:
        print(f"Erreur lors de la connexion au serveur local : {e}")
        sys.exit(1)

    # Démarrage des threads pour relayer les données
    thread_send = threading.Thread(target=handle_local_request, args=(local_socket, tunnel_socket))
    thread_recv = threading.Thread(target=handle_tunnel_response, args=(tunnel_socket, local_socket))

    thread_send.start()
    thread_recv.start()

    thread_send.join()
    thread_recv.join()

if __name__ == '__main__':
    main()
