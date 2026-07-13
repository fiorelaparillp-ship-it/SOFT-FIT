package vista;

import javax.swing.*;
import java.awt.*;

public class Menu extends JFrame {

    public Menu() {

        setTitle("SOFT-FIT Dashboard");
        setSize(1000,600);
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setLocationRelativeTo(null);
        setLayout(null);

        // PANEL LATERAL
        JPanel panelMenu = new JPanel();
        panelMenu.setBounds(0,0,250,600);
        panelMenu.setBackground(new Color(45,0,70));
        panelMenu.setLayout(null);
        add(panelMenu);

        JLabel titulo = new JLabel("SOFT-FIT");
        titulo.setForeground(Color.WHITE);
        titulo.setFont(new Font("Arial", Font.BOLD, 24));
        titulo.setBounds(50,30,200,40);
        panelMenu.add(titulo);

        JButton btnClientes = new JButton("Clientes");
        btnClientes.setBounds(30,120,180,40);
        panelMenu.add(btnClientes);
        btnClientes.addActionListener(e -> {

    ClientesForm clientes = new ClientesForm();
    clientes.setVisible(true);

});

        JButton btnMembresias = new JButton("Membresías");
        btnMembresias.setBounds(30,180,180,40);
        panelMenu.add(btnMembresias);

        JButton btnProductos = new JButton("Productos");
        btnProductos.setBounds(30,240,180,40);
        panelMenu.add(btnProductos);

        JButton btnInventario = new JButton("Inventario");
        btnInventario.setBounds(30,300,180,40);
        panelMenu.add(btnInventario);

        JButton btnCaja = new JButton("Caja");
        btnCaja.setBounds(30,360,180,40);
        panelMenu.add(btnCaja);

        // PANEL PRINCIPAL
        JPanel panelPrincipal = new JPanel();
        panelPrincipal.setBounds(250,0,750,600);
        panelPrincipal.setBackground(Color.WHITE);
        panelPrincipal.setLayout(null);
        add(panelPrincipal);

        JLabel bienvenida = new JLabel("Bienvenido a SOFT-FIT");
        bienvenida.setFont(new Font("Arial", Font.BOLD, 28));
        bienvenida.setBounds(180,50,400,40);
        panelPrincipal.add(bienvenida);

    }

}