package conexion;

import java.sql.Connection;
import java.sql.DriverManager;

public class Conexion {

    Connection conectar = null;

    String usuario = "root";
    String password = "";
    String bd = "softfit";
    String ip = "localhost";
    String puerto = "3306";

    String cadena = "jdbc:mysql://" + ip + ":" + puerto + "/" + bd;

    public Connection establecerConexion() {

        try {

            Class.forName("com.mysql.cj.jdbc.Driver");

            conectar = DriverManager.getConnection(cadena, usuario, password);

            System.out.println("Conexión exitosa");

        } catch (Exception e) {

            System.out.println("Error: " + e.toString());

        }

        return conectar;
    }
}