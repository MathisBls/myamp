// myshell.c

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <direct.h>  // Pour _chdir et _mkdir sur Windows
#include <windows.h> // Pour les couleurs et les commandes système
#include <conio.h>   // Pour getch (gestion des touches comme Tab)
#include <io.h>      // Pour l'accès aux fichiers (open, close)
#include <fcntl.h>   // Pour les définitions de _O_CREAT et _O_WRONLY
#include <sys/stat.h> // Pour les définitions de _S_IREAD et _S_IWRITE

// Fonction pour changer de répertoire au lancement
void initialize_shell() {
    if (_chdir("C:/myamp") != 0) {
        perror("Erreur lors du changement de répertoire vers C:/myamp");
    }
}

// Fonction pour la commande cd (changer de répertoire)
void my_cd(char *path) {
    if (_chdir(path) != 0) {
        perror("cd error");
    }
}

// Fonction pour la commande mkdir (créer un dossier)
void my_mkdir(char *directory) {
    if (_mkdir(directory) != 0) {
        perror("mkdir error");
    }
}

// Fonction pour la commande touch (créer un fichier)
void my_touch(char *filename) {
    // Utilisation de _S_IREAD | _S_IWRITE pour les permissions
    int fd = _open(filename, _O_CREAT | _O_WRONLY | _O_TRUNC, _S_IREAD | _S_IWRITE);
    if (fd < 0) {
        perror("touch error");
    } else {
        _close(fd);
    }
}

// Fonction pour changer les couleurs dans le terminal Windows
void set_color(int color) {
    HANDLE hConsole = GetStdHandle(STD_OUTPUT_HANDLE);

    // Définir la couleur du texte en rouge clair (255, 30, 70)
    SetConsoleTextAttribute(hConsole, FOREGROUND_RED | FOREGROUND_INTENSITY); // Cela rend le texte en rouge clair
}


// Fonction pour afficher les fichiers et dossiers avec la commande ls
void my_ls() {
    WIN32_FIND_DATA findFileData;
    HANDLE hFind = FindFirstFile("*", &findFileData);  // Trouve tous les fichiers dans le répertoire

    if (hFind == INVALID_HANDLE_VALUE) {
        printf("Aucun fichier ou dossier trouvé.\n");
        return;
    }

    do {
        if (findFileData.dwFileAttributes & FILE_ATTRIBUTE_DIRECTORY) {
            set_color(FOREGROUND_BLUE | FOREGROUND_INTENSITY);  // Dossiers en bleu
            printf("%s/ ", findFileData.cFileName);
        } else {
            set_color(FOREGROUND_GREEN | FOREGROUND_INTENSITY);  // Fichiers en vert
            printf("%s ", findFileData.cFileName);
        }
    } while (FindNextFile(hFind, &findFileData) != 0);

    FindClose(hFind);
    set_color(FOREGROUND_RED | FOREGROUND_GREEN | FOREGROUND_BLUE);  // Reset couleur
    printf("\n");
}

// Fonction pour compléter automatiquement les noms de fichiers ou de dossiers avec Tab
void autocomplete(char *input) {
    WIN32_FIND_DATA findFileData;
    char temp[256];
    strcpy(temp, input); // Conserve l'entrée actuelle
    strcat(temp, "*"); // Ajouter un wildcard pour la recherche

    HANDLE hFind = FindFirstFile(temp, &findFileData);  // Trouve les fichiers correspondants

    if (hFind != INVALID_HANDLE_VALUE) {
        // Si un fichier ou dossier est trouvé, compléter
        if (findFileData.dwFileAttributes & FILE_ATTRIBUTE_DIRECTORY) {
            strcat(input, findFileData.cFileName);
        }
    }
    FindClose(hFind);
}

// Fonction pour exécuter des commandes
void execute_command(char *command) {
    char *args[3];
    char *token = strtok(command, " ");
    int i = 0;

    while (token != NULL && i < 3) {
        args[i++] = token;
        token = strtok(NULL, " ");
    }
    args[i] = NULL;

    if (args[0] == NULL) return; // Si l'utilisateur n'entre rien

    // Comparer la commande avec cd, mkdir, touch, ls
    if (strcmp(args[0], "cd") == 0) {
        if (args[1] != NULL) {
            my_cd(args[1]);
        } else {
            printf("cd: missing argument\n");
        }
    } else if (strcmp(args[0], "mkdir") == 0) {
        if (args[1] != NULL) {
            my_mkdir(args[1]);
        } else {
            printf("mkdir: missing argument\n");
        }
    } else if (strcmp(args[0], "touch") == 0) {
        if (args[1] != NULL) {
            my_touch(args[1]);
        } else {
            printf("touch: missing argument\n");
        }
    } else if (strcmp(args[0], "ls") == 0) {
        my_ls();
    } else {
        system(command); // Exécute les commandes système comme dir, cls, etc.
    }
}

int main() {
    char command[256];

    // Initialiser le shell dans le répertoire C:/myamp
    initialize_shell();

    while (1) {
        set_color(FOREGROUND_RED | FOREGROUND_GREEN | FOREGROUND_INTENSITY); // Appliquer la couleur rouge clair
        printf("%s$ ", _getcwd(NULL, 0));  // Affiche le répertoire actuel
        int idx = 0;
        int ch;

        // Lire la commande caractère par caractère pour gérer la touche Tab
        while ((ch = _getch()) != '\r') {  // '\r' est la touche Entrée
            if (ch == '\t') {  // Si c'est la touche Tab
                autocomplete(command);
                printf("\r%s$ %s", _getcwd(NULL, 0), command);  // Reprint après auto-complétion
            } else if (ch == 8) {  // Touche Backspace
                if (idx > 0) {
                    command[--idx] = '\0';
                    printf("\b \b");  // Efface le dernier caractère
                }
            } else if (ch >= 32 && ch <= 126) {  // Filtrer les entrées
                command[idx++] = ch;
                command[idx] = '\0';
                printf("%c", ch);  // Affiche le caractère tapé
            }
        }
        command[idx] = '\0';  // Fin de la commande

        if (strcmp(command, "exit") == 0) {
            break;
        }

        execute_command(command);  // Exécuter la commande
        printf("\n");  // Aller à la ligne après l'exécution de la commande
    }

    return 0;
}
