// Prueba para ejecutar Mongo con Docker

// 'express' es un framework de node.js
import express from 'express'
// 'mongoose' es una librería que nos permite conectarnos con Mongo
import mongoose from 'mongoose'

// Definimos un modelo con dos atributos (tipo y estado)
const Cliente = mongoose.model('Usuario', new mongoose.Schema({
  usuario: String,
  nombreCompleto: String,
  direccion: String,
  ciudad: String,
  email: String,
  telefono: String,
  compras: String,
  deseos: String,
}))

// Creamos nuestra aplicación
const app = express()

// Indicamos a mongoose que se tiene que conectar al servidor indicado a continuación
// El usuario es 'usuario' y la contraseña 'pass'
// Se conectará al contenedor 'monguito' en el puerto 27017
// La base de datos es 'Tienda'
// El usuario será tipo 'admin'
mongoose.connect('mongodb://nico:password@monguito:27017/miapp?authSource=admin')

// En la ruta '/' lista todos los clientes guardados en la base de datos
app.get('/', async (_req, res) => {
  console.log('listando clientes...')
  const clientes = await Cliente.find();
  return res.send(clientes)
})

// En la ruta '/crear' crea un animal con tipo 'Chanchito' y estado 'feliz'
app.get('/crear', async (_req, res) => {
  console.log('creando...')
  await Cliente.create({ 
    usuario: 'Usuario1',
    nombreCompleto: 'Antonio Fernandez',
    direccion: 'Calle Inventada nº 1',
    ciudad: 'Valdepeñas',
    email: 'email@email.com',
    telefono: '666666666',
    compras: 'compras',
    deseos: 'deseos',
   })
  return res.send('ok')
})

// La aplicación se queda escuchando en el puerto 3000
app.listen(3000, () => console.log('listening...'))