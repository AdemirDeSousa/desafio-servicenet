import { Button, ModalBody, ModalHeader } from "@chakra-ui/react";
import { customAxios } from "../../service/axios";

const ModalDelete = ({ id }) => {
  const onDelete = () => {
    customAxios.delete(`/usuarios/${id}`).then(alert("Usuario deletado"));
  };

  return (
    <>
      <ModalHeader>Deletar Usuario</ModalHeader>

      <ModalBody pb={6}>
        <h3>Deseja Excluir o Usuario ?</h3>
        <Button onClick={onDelete}>Sim, quero excluir</Button>
      </ModalBody>
    </>
  );
};

export default ModalDelete;
