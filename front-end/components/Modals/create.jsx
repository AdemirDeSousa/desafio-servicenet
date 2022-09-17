import {
  Button,
  FormControl,
  FormLabel,
  Input,
  ModalBody,
  ModalHeader,
  Text,
  useToast,
} from "@chakra-ui/react";
import { useState } from "react";
import { customAxios } from "../../service/axios";

const ModalCreate = ({ modalState }) => {
  const toast = useToast();

  const [values, setValues] = useState({});
  const [errors, setErrors] = useState({});

  const onChange = (e) => {
    const value = e.target.value;
    const name = e.target.name;

    setValues({
      ...values,
      [name]: value,
    });
  };

  const onSubmit = (e) => {
    e.preventDefault();

    customAxios
      .post("/usuarios", values)
      .then(() => {
        toast({
          title: "Usuario criado com sucesso",
          status: "success",
          duration: 2000,
          isClosable: true,
          position: "top-right",
        });
        modalState(false);
      })
      .catch((error) => {
        setErrors(error?.response?.data?.data);
      });
  };

  return (
    <>
      <ModalHeader>Criar Usuario</ModalHeader>

      <ModalBody pb={6}>
        <form onSubmit={onSubmit}>
          <FormControl mt={4}>
            <FormLabel>Nome</FormLabel>
            <Input
              onChange={onChange}
              type={"text"}
              name="name"
              isInvalid={errors?.name}
            />
            {errors?.name && (
              <Text fontSize="sm" color="red.600">
                {errors.name.toString()}
              </Text>
            )}
          </FormControl>
          <FormControl mt={4}>
            <FormLabel>Data de Nascimento</FormLabel>
            <Input
              onChange={onChange}
              type={"date"}
              name="birthdate"
              isInvalid={errors?.birthdate}
            />
            {errors?.birthdate && (
              <Text fontSize="sm" color="red.600">
                {errors.birthdate.toString()}
              </Text>
            )}
          </FormControl>
          <FormControl mt={4}>
            <FormLabel>Email</FormLabel>
            <Input
              onChange={onChange}
              type={"email"}
              name="email"
              isInvalid={errors?.email}
            />
            {errors?.email && (
              <Text fontSize="sm" color="red.600">
                {errors.email.toString()}
              </Text>
            )}
          </FormControl>
          <FormControl mt={4}>
            <FormLabel>Senha</FormLabel>
            <Input
              type={"password"}
              name="password"
              placeholder="Senha"
              onChange={onChange}
              isInvalid={errors?.password}
            />
            {errors?.password && (
              <Text fontSize="sm" color="red.600">
                {errors.password.toString()}
              </Text>
            )}
          </FormControl>
          <FormControl mt={4}>
            <FormLabel>Confirmar senha</FormLabel>
            <Input
              type={"password"}
              name="password_confirmation"
              placeholder="Confirmar senha"
              onChange={onChange}
            />
          </FormControl>
          <Button marginTop="1.5rem" width="100%" type="submit">
            Salvar
          </Button>
        </form>
      </ModalBody>
    </>
  );
};

export default ModalCreate;
