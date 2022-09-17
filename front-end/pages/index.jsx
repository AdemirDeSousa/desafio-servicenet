import { DeleteIcon } from "@chakra-ui/icons";
import {
  Table,
  Thead,
  Tbody,
  Tr,
  Th,
  TableCaption,
  TableContainer,
  ButtonGroup,
  Button,
  IconButton,
  Modal,
  ModalOverlay,
  ModalContent,
  ModalCloseButton,
  Input,
} from "@chakra-ui/react";
import { useEffect, useState } from "react";
import ModalCreate from "../components/Modals/create";
import ModalDelete from "../components/Modals/delete";
import ModalEdit from "../components/Modals/edit";
import { customAxios } from "../service/axios";

export default function Home() {
  const [open, setOpen] = useState(false);
  const [modalType, setModalType] = useState("");
  const [userId, setUserId] = useState({});
  const [users, setUsers] = useState([]);
  const [filter, setFilter] = useState({ name: "" });

  useEffect(() => {
    const getUsers = () => {
      customAxios.get("/usuarios", { params: filter }).then((res) => {
        setUsers(res.data.data);
      });
    };

    getUsers();
  }, [filter]);

  const onClose = () => {
    setOpen(false);
  };

  const onOpen = (id, type) => {
    if (id) {
      setUserId(id);
    }

    setModalType(type);
    setOpen(true);
  };

  const onFilter = (e) => {
    e.preventDefault();

    setFilter({
      name: e.target.elements.name.value,
    });
  };

  return (
    <>
      <Button onClick={() => onOpen(null, "create")}>Criar</Button>
      <form onSubmit={onFilter}>
        <Input type="search" name="name" />
        <Button type="submit">Pesquisar</Button>
      </form>
      <TableContainer>
        <Table>
          <TableCaption>Modulo de Usuarios</TableCaption>
          <Thead>
            <Tr>
              <Th>Matricula</Th>
              <Th>Nome</Th>
              <Th>Email</Th>
              <Th>Actions</Th>
            </Tr>
          </Thead>
          <Tbody>
            {users?.map((item) => (
              <Tr key={item.id}>
                <Th>{item.enrollment}</Th>
                <Th>{item.name}</Th>
                <Th>{item.email}</Th>
                <Th>
                  <ButtonGroup size="sm" isAttached variant="outline">
                    <Button onClick={() => onOpen(item.id, "edit")}>
                      Editar
                    </Button>
                    <IconButton
                      onClick={() => onOpen(item.id, "delete")}
                      icon={<DeleteIcon />}
                    />
                  </ButtonGroup>
                </Th>
              </Tr>
            ))}
          </Tbody>
        </Table>
      </TableContainer>

      <Modal isOpen={open} onClose={onClose}>
        <ModalOverlay />
        <ModalContent>
          <ModalCloseButton />
          {modalType === "edit" && <ModalEdit id={userId} />}
          {modalType === "create" && <ModalCreate />}
          {modalType === "delete" && <ModalDelete id={userId} />}
        </ModalContent>
      </Modal>
    </>
  );
}
