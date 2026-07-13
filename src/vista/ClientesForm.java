package vista;

import conexion.Conexion;
import javax.swing.table.DefaultTableModel;
import java.sql.ResultSet;

import javax.swing.*;
import java.awt.*;
import java.sql.Connection;
import java.sql.PreparedStatement;

public class ClientesForm extends JFrame {

    JTextField txtNombre, txtDni, txtTelefono, txtCorreo;
    JButton btnGuardar;
    JTable tablaClientes;
DefaultTableModel modeloTabla;

    public ClientesForm() {

        setTitle("Clientes SOFT-FIT");
        setSize(500,650);
        setLocationRelativeTo(null);
        setLayout(null);

        JLabel titulo = new JLabel("REGISTRO CLIENTES");
        titulo.setFont(new Font("Arial", Font.BOLD, 22));
        titulo.setBounds(120,30,300,40);
        add(titulo);

        JLabel lblNombre = new JLabel("Nombre:");
        lblNombre.setBounds(50,100,100,30);
        add(lblNombre);

        txtNombre = new JTextField();
        txtNombre.setBounds(150,100,250,30);
        add(txtNombre);

        JLabel lblDni = new JLabel("DNI:");
        lblDni.setBounds(50,150,100,30);
        add(lblDni);

        txtDni = new JTextField();
        txtDni.setBounds(150,150,250,30);
        add(txtDni);

        JLabel lblTelefono = new JLabel("Teléfono:");
        lblTelefono.setBounds(50,200,100,30);
        add(lblTelefono);

        txtTelefono = new JTextField();
        txtTelefono.setBounds(150,200,250,30);
        add(txtTelefono);

        JLabel lblCorreo = new JLabel("Correo:");
        lblCorreo.setBounds(50,250,100,30);
        add(lblCorreo);

        txtCorreo = new JTextField();
        txtCorreo.setBounds(150,250,250,30);
        add(txtCorreo);

        btnGuardar = new JButton("Guardar");
        JTable tablaClientes;
DefaultTableModel modeloTabla;

        btnGuardar.setBounds(180,330,120,40);
        add(btnGuardar);

        btnGuardar.addActionListener(e -> guardarCliente());
        modeloTabla = new DefaultTableModel();

modeloTabla.addColumn("ID");
modeloTabla.addColumn("Nombre");
modeloTabla.addColumn("DNI");
modeloTabla.addColumn("Teléfono");
modeloTabla.addColumn("Correo");

tablaClientes = new JTable(modeloTabla);

JScrollPane scroll = new JScrollPane(tablaClientes);
scroll.setBounds(20,390,440,150);

add(scroll);

mostrarClientes();

    }

    public void guardarCliente() {

        try {

            Conexion objetoConexion = new Conexion();

            Connection conexion = objetoConexion.establecerConexion();

            String consulta = "INSERT INTO clientes(nombre,dni,telefono,correo) VALUES(?,?,?,?)";

            PreparedStatement ps = conexion.prepareStatement(consulta);

            ps.setString(1, txtNombre.getText());
            ps.setString(2, txtDni.getText());
            ps.setString(3, txtTelefono.getText());
            ps.setString(4, txtCorreo.getText());

            ps.executeUpdate();

            JOptionPane.showMessageDialog(null,"Cliente guardado");
            mostrarClientes();

            txtNombre.setText("");
            txtDni.setText("");
            txtTelefono.setText("");
            txtCorreo.setText("");

        } catch (Exception e) {

            JOptionPane.showMessageDialog(null,"Error: " + e.toString());

        }
        public void mostrarClientes() {

    try {

        modeloTabla.setRowCount(0);

        Conexion objetoConexion = new Conexion();

        Connection conexion = objetoConexion.establecerConexion();

        String consulta = "SELECT * FROM clientes";

        PreparedStatement ps = conexion.prepareStatement(consulta);

        ResultSet rs = ps.executeQuery();

        while(rs.next()) {

            Object[] fila = {

                    rs.getInt("id_cliente"),
                    rs.getString("nombre"),
                    rs.getString("dni"),
                    rs.getString("telefono"),
                    rs.getString("correo")

            };

            modeloTabla.addRow(fila);

        }

    } catch (Exception e) {

        JOptionPane.showMessageDialog(null,"Error: " + e.toString());

    }



    }

}