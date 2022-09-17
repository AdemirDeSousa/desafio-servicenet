import { Button, ModalBody, ModalHeader, useToast } from "@chakra-ui/react";
import { customAxios } from "../../service/axios";

const ModalDelete = ({ id, modalState }) => {
  const toast = useToast();

  const onDelete = () => {
    customAxios.delete(`/usuarios/${id}`).then(() => {
      toast({
        title: "Usuario deletado com sucesso",
        status: "success",
        duration: 2000,
        isClosable: true,
        position: "top-right",
      });
      modalState(false);
    });
  };

  return (
    <>
      <ModalHeader>Deletar Usuario</ModalHeader>

      <ModalBody pb={6} display="flex" flexDirection="column" gap="1.5rem">
        <h3>Deseja Excluir o Usuario ?</h3>
        <Button onClick={onDelete}>Sim, quero excluir</Button>
      </ModalBody>
    </>
  );
};

export default ModalDelete;
