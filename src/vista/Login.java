package vista;

import conexion.Conexion;
import vista.Menu;

import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;

public class Login extends JFrame {

    JTextField txtUsuario;
    JPasswordField txtPassword;
    JButton btnIngresar;

    public Login() {

        setTitle("SOFT-FIT LOGIN");
        setSize(500,400);
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setLocationRelativeTo(null);
        setLayout(null);

        JLabel titulo = new JLabel("SOFT-FIT");
        titulo.setFont(new Font("Arial", Font.BOLD, 28));
        titulo.setBounds(170,30,200,40);
        add(titulo);

        JLabel lblUsuario = new JLabel("Usuario:");
        lblUsuario.setBounds(100,120,100,30);
        add(lblUsuario);

        txtUsuario = new JTextField();
        txtUsuario.setBounds(180,120,180,30);
        add(txtUsuario);

        JLabel lblPassword = new JLabel("Contraseña:");
        lblPassword.setBounds(100,180,100,30);
        add(lblPassword);

        txtPassword = new JPasswordField();
        txtPassword.setBounds(180,180,180,30);
        add(txtPassword);

        btnIngresar = new JButton("Ingresar");
        btnIngresar.setBounds(180,250,120,40);
        add(btnIngresar);

        btnIngresar.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                validarLogin();

            }
        });

    }

    public void validarLogin() {

        String usuario = txtUsuario.getText();
        String password = String.valueOf(txtPassword.getPassword());

        try {

            Conexion objetoConexion = new Conexion();

            Connection conexion = objetoConexion.establecerConexion();

            String consulta = "SELECT * FROM usuarios WHERE usuario=? AND password=?";

            PreparedStatement ps = conexion.prepareStatement(consulta);

            ps.setString(1, usuario);
            ps.setString(2, password);

            ResultSet rs = ps.executeQuery();

            if(rs.next()) {

                JOptionPane.showMessageDialog(null,"Bienvenido a SOFT-FIT");
                Menu menu = new Menu();
                menu.setVisible(true);

                dispose();

            } else {

                JOptionPane.showMessageDialog(null,"Usuario o contraseña incorrectos");

            }

        } catch (Exception e) {

            JOptionPane.showMessageDialog(null,"Error: " + e.toString());

        }

    }

}