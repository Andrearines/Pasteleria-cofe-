<?php
namespace models;
class ordenes extends main{

    public static $table = "ordenes";
    public $fecha;
    public $todos;
    
    public function __construct($args=[]){
        $this->fecha=$args["fecha"]?? null;
        $this->todos=$args["todos"] ?? null;
    }

    public function ordenes(){
        $query = "SELECT users.nombre, ordenes.direccion, pasteles.nombre as nombre_pastel, 
                  pasteles.img, pasteles.disponible, pedidos.fecha, pedidos.hora, 
                  ordenes.cantidad, (ordenes.cantidad * pasteles.precio) as total 
                  FROM users 
                  INNER JOIN pedidos ON pedidos.usuario_id = users.id 
                  INNER JOIN ordenes ON ordenes.pedidos_id = pedidos.id 
                  INNER JOIN pasteles ON ordenes.pastel_id = pasteles.id
                  WHERE pedidos.fecha >= CURDATE()";
        
        // Aplicar filtros adicionales
        if($this->todos !== "true" && $this->fecha) {
            $query .= " AND pedidos.fecha = '" . $this->fecha . "'";
        }
        
        $query .= " ORDER BY pedidos.fecha DESC, pedidos.hora DESC";
        
        $r = self::$db->query($query);
        
        if(!$r) {
            // Si hay error en la consulta, retornar el error
            return ['error' => self::$db->error];
        }
        
        $resultados = [];
        
        while($row = $r->fetch_assoc()) {
            $resultados[] = $row;
        }
        
        return $resultados;
    }

}