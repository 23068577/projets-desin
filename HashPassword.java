import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.util.ArrayList;
import java.util.Scanner;

// Créer la fenêtre principale
        JFrame frame = new JFrame("Blog Collaboratif");
        frame.setSize(500, 400);
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        
        // Panneau principal
        JPanel panel = new JPanel();
        panel.setLayout(new GridLayout(4, 1));
        frame.add(panel);

        // Titre de la page
        JLabel titleLabel = new JLabel("Bienvenue sur le Blog Collaboratif", SwingConstants.CENTER);
        titleLabel.setFont(new Font("Arial", Font.BOLD, 18));
        titleLabel.setForeground(Color.BLUE);
        panel.add(titleLabel);

        // Boutons de navigation
        JButton accueilButton = new JButton("Accueil");
        JButton connexionButton = new JButton("Connexion");
        JButton inscriptionButton = new JButton("Inscription");
        
        // Ajouter les boutons
        panel.add(accueilButton);
        panel.add(connexionButton);
        panel.add(inscriptionButton);

        // Action pour les boutons
        connexionButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                JOptionPane.showMessageDialog(frame, "Redirection vers Connexion...");
            }
        });

        inscriptionButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                JOptionPane.showMessageDialog(frame, "Redirection vers Inscription...");
            }
        });

        // Afficher la fenêtre
        frame.setVisible(true);
    }
}
 
import org.mindrot.jbcrypt.BCrypt;

public class HashPassword {
    public static void main(String[] args) {
        String motDePasse = "motdepasse123";
        String motDePasseHashé = BCrypt.hashpw(motDePasse, BCrypt.gensalt());
        System.out.println("Mot de passe haché : " + motDePasseHashé);
    }
}
public void ajouterCommentaire(int indexArticle, String texteCommentaire, String auteurCommentaire) {
    if (indexArticle >= 0 && indexArticle < articles.size()) {
        if (texteCommentaire == null || texteCommentaire.trim().isEmpty()) {
            System.out.println("Le commentaire ne peut pas être vide.");
            return;
        }
        Commentaire commentaire = new Commentaire(texteCommentaire, auteurCommentaire);
        articles.get(indexArticle).ajouterCommentaire(commentaire);
    } else {
        System.out.println("Article non trouvé!");
    }
}
public static void afficherMenu() {
    System.out.println("1. Publier un article");
    System.out.println("2. Ajouter un commentaire");
    System.out.println("3. Afficher les articles");
    System.out.println("4. Quitter");
}
class Article {
    private String titre;
    private String contenu;
    private String auteur;
    private List<Commentaire> commentaires;

    public Article(String titre, String contenu, String auteur) {
        this.titre = titre;
        this.contenu = contenu;
        this.auteur = auteur;
        this.commentaires = new ArrayList<>();
    }

    public void ajouterCommentaire(Commentaire commentaire) {
        commentaires.add(commentaire);
    }

    @Override
    public String toString() {
        StringBuilder sb = new StringBuilder();
        sb.append("Titre: ").append(titre).append("\n");
        sb.append("Auteur: ").append(auteur).append("\n");
        sb.append("Contenu: ").append(contenu).append("\n");
        sb.append("Commentaires:\n");
        for (Commentaire commentaire : commentaires) {
            sb.append(" - ").append(commentaire.getTexte()).append("\n");
        }
        return sb.toString();
    }
}
class Commentaire {
    private String texte;
    private String auteur;

    public Commentaire(String texte, String auteur) {
        this.texte = texte;
        this.auteur = auteur;
    }

    public String getTexte() {
        return texte;
    }

    public String getAuteur() {
        return auteur;
    }
}
class Blog {
    private List<Article> articles;

    public Blog() {
        articles = new ArrayList<>();
    }

    public void publierArticle(String titre, String contenu, String auteur) {
        Article article = new Article(titre, contenu, auteur);
        articles.add(article);
    }

    public void afficherArticles() {
        if (articles.isEmpty()) {
            System.out.println("Aucun article disponible.");
        } else {
            for (Article article : articles) {
                System.out.println(article);
                System.out.println("------------------------------------");
            }
        }
    }

    public void ajouterCommentaire(int indexArticle, String texteCommentaire, String auteurCommentaire) {
        if (indexArticle >= 0 && indexArticle < articles.size()) {
            if (texteCommentaire == null || texteCommentaire.trim().isEmpty()) {
                System.out.println("Le commentaire ne peut pas être vide.");
                return;
            }
            Commentaire commentaire = new Commentaire(texteCommentaire, auteurCommentaire);
            articles.get(indexArticle).ajouterCommentaire(commentaire);
        } else {
            System.out.println("Article non trouvé!");
        }
    }
}
public class Main {
    public static void afficherMenu() {
        System.out.println("1. Publier un article");
        System.out.println("2. Ajouter un commentaire");
        System.out.println("3. Afficher les articles");
        System.out.println("4. Quitter");
    }

    public static void main(String[] args) {
        Blog blog = new Blog();
        Scanner scanner = new Scanner(System.in);

        boolean continuer = true;
        while (continuer) {
            afficherMenu();
            System.out.print("Choisissez une option: ");
            int choix = scanner.nextInt();
            scanner.nextLine();  // Consommer la ligne restante

            switch (choix) {
                case 1:
                    System.out.print("Titre de l'article: ");
                    String titre = scanner.nextLine();
                    System.out.print("Contenu de l'article: ");
                    String contenu = scanner.nextLine();
                    System.out.print("Auteur de l'article: ");
                    String auteur = scanner.nextLine();
                    blog.publierArticle(titre, contenu, auteur);
                    break;
                case 2:
                    blog.afficherArticles();
                    System.out.print("Choisissez l'index de l'article pour ajouter un commentaire: ");
                    int indexArticle = scanner.nextInt();
                    scanner.nextLine(); // Consommer la ligne restante
                    System.out.print("Texte du commentaire: ");
                    String texteCommentaire = scanner.nextLine();
                    System.out.print("Auteur du commentaire: ");
                    String auteurCommentaire = scanner.nextLine();
                    blog.ajouterCommentaire(indexArticle, texteCommentaire, auteurCommentaire);
                    break;
                case 3:
                    blog.afficherArticles();
                    break;
                case 4:
                    continuer = false;
                    System.out.println("Merci d'avoir utilisé le blog !");
                    break;
                default:
                    System.out.println("Option invalide. Essayez à nouveau.");
            }
        }
        scanner.close();
    }
}





